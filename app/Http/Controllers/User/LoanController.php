<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Plan;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    // Show the loan application form
    public function create(Request $request)
    {
        $user = $request->user();

        $amountOptions = Plan::query()
            ->where('types', 'amount')
            ->where('status', 'active')
            ->orderByDesc('id')
            ->get(['id', 'label', 'value']);

        $durationOptions = Plan::query()
            ->where('types', 'duration')
            ->where('status', 'active')
            ->orderByDesc('id')
            ->get(['id', 'label', 'value']);

        $reasonOptions = Plan::query()
            ->where('types', 'reason')
            ->where('status', 'active')
            ->orderByDesc('id')
            ->get(['id', 'label', 'value']);

        return view('user.loan.apply', compact('user', 'amountOptions', 'durationOptions', 'reasonOptions'));
    }

    // Preview the loan with computed summary and schedule
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'amount_value' => ['required', 'string'],
            'duration_value' => ['required', 'string'],
            'reason_value' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Resolve labels and interest rate
        $amountPlan = Plan::where(['types' => 'amount', 'value' => $validated['amount_value'], 'status' => 'active'])->first(['label', 'value', 'interest_rate']);
        $durationPlan = Plan::where(['types' => 'duration', 'value' => $validated['duration_value'], 'status' => 'active'])->first(['label', 'value', 'interest_rate']);
        $reasonPlan = Plan::where(['types' => 'reason', 'value' => $validated['reason_value'], 'status' => 'active'])->first(['label', 'value']);

        $amountLabel = $amountPlan?->label;
        $durationLabel = $durationPlan?->label;
        $reasonLabel = $reasonPlan?->label;

        // principal
        $principal = is_numeric($validated['amount_value'])
            ? (float) $validated['amount_value']
            : (float) (preg_replace('/[^0-9.]/', '', $validated['amount_value']) ?: 0);

        // duration months
        $durationMonths = null;
        $durationValue = $validated['duration_value'];
        if (is_numeric($durationValue)) {
            $durationMonths = (int) $durationValue;
        } else {
            $lower = strtolower($durationValue);
            if (preg_match('/([0-9]+)\s*(year|years|yr|yrs)/', $lower, $m)) {
                $durationMonths = (int) $m[1] * 12;
            } elseif (preg_match('/([0-9]+)\s*(month|months|mo)/', $lower, $m)) {
                $durationMonths = (int) $m[1];
            }
        }

        $interestRate = $durationPlan?->interest_rate ?? $amountPlan?->interest_rate ?? 0;

        $interestAmount = round($principal * ($interestRate / 100) * (($durationMonths ?? 0) / 12), 2);
        $totalPayable = round($principal + $interestAmount, 2);
        $monthlyInstallment = $durationMonths ? round($totalPayable / $durationMonths, 2) : null;

        // simple monthly schedule: equal principal+interest per month (based on simple-interest total)
        $schedule = [];
        if ($durationMonths && $monthlyInstallment) {
            $perMonthInterest = round(($interestAmount / $durationMonths), 2);
            for ($i = 1; $i <= $durationMonths; $i++) {
                $schedule[] = [
                    'date' => now()->addMonths($i)->startOfDay(),
                    'emi' => $monthlyInstallment,
                    'interest' => $perMonthInterest,
                ];
            }
        }

        return view('user.loan.preview', compact(
            'user',
            'amountLabel',
            'durationLabel',
            'reasonLabel',
            'validated',
            'principal',
            'durationMonths',
            'interestRate',
            'interestAmount',
            'totalPayable',
            'monthlyInstallment',
            'schedule'
        ));
    }

    // Handle submission: do NOT persist yet; keep in session until deposit completes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount_value' => ['required', 'string'],
            'duration_value' => ['required', 'string'],
            'reason_value' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Resolve labels from active plans for auditability
        $amountLabel = Plan::where(['types' => 'amount', 'value' => $validated['amount_value'], 'status' => 'active'])->value('label');
        $durationPlan = Plan::where(['types' => 'duration', 'value' => $validated['duration_value'], 'status' => 'active'])->first(['label', 'value', 'interest_rate']);
        $durationLabel = $durationPlan?->label;
        $reasonLabel = Plan::where(['types' => 'reason', 'value' => $validated['reason_value'], 'status' => 'active'])->value('label');

        // Interest calculation inputs
        // Principal: try to parse from selected amount value; if not numeric, try to parse digits
        $principal = null;
        if (is_numeric($validated['amount_value'])) {
            $principal = (float) $validated['amount_value'];
        } else {
            // extract numeric part like "10000" from "10,000 BDT"
            $digits = preg_replace('/[^0-9.]/', '', $validated['amount_value']);
            $principal = $digits !== '' ? (float) $digits : null;
        }

        // Duration in months: parse common patterns like "12 months", "1 year", "24 month"
        $durationMonths = null;
        $durationValue = $validated['duration_value'];
        if (is_numeric($durationValue)) {
            // assume direct months count if numeric
            $durationMonths = (int) $durationValue;
        } else {
            $lower = strtolower($durationValue);
            if (preg_match('/([0-9]+)\s*(year|years|yr|yrs)/', $lower, $m)) {
                $durationMonths = (int) $m[1] * 12;
            } elseif (preg_match('/([0-9]+)\s*(month|months|mo)/', $lower, $m)) {
                $durationMonths = (int) $m[1];
            }
        }

        // Interest rate: prefer duration plan's interest_rate; fallback to amount plan interest or 0
        $amountRate = Plan::where(['types' => 'amount', 'value' => $validated['amount_value'], 'status' => 'active'])->value('interest_rate');
        $interestRate = $durationPlan?->interest_rate ?? $amountRate ?? 0;

        // Compute simple interest for the whole term: interest = principal * (rate/100) * (months/12)
        $interestAmount = null;
        $totalPayable = null;
        $monthlyInstallment = null;
        if ($principal !== null && $durationMonths && $interestRate !== null) {
            $interestAmount = round($principal * ($interestRate / 100) * ($durationMonths / 12), 2);
            $totalPayable = round($principal + $interestAmount, 2);
            $monthlyInstallment = round($totalPayable / max(1, $durationMonths), 2);
        }

        // Keep in session until deposit completes to avoid duplicate DB entries
        $payload = [
            'user_id' => $user->id,
            'amount_value' => $validated['amount_value'],
            'amount_label' => $amountLabel,
            'duration_value' => $validated['duration_value'],
            'duration_label' => $durationLabel,
            'reason_value' => $validated['reason_value'],
            'reason_label' => $reasonLabel,
            'principal' => $principal,
            'duration_months' => $durationMonths,
            'interest_rate' => $interestRate,
            'interest_amount' => $interestAmount,
            'total_payable' => $totalPayable,
            'monthly_installment' => $monthlyInstallment,
            'deposit_required_amount' => $principal ? round($principal * 0.10, 2) : null,
        ];

        $request->session()->put('loan_apply', $payload);

        // Go to documents upload step (session-backed)
        return redirect()->route('user.loan.documents.form')->with('status', 'আপনার আবেদন সংরক্ষণ করা হয়েছে, এখন ডকুমেন্ট আপলোড করুন।');
    }

    // Documents step: form (session-backed)
    public function documentsForm(Request $request)
    {
        $data = $request->session()->get('loan_apply');
        if (!$data || ($data['user_id'] ?? null) !== $request->user()->id) {
            return redirect()->route('user.loan.apply')->with('error', 'প্রথমে আবেদন শুরু করুন।');
        }
        $docFrontPath = $data['doc_front_path'] ?? null;
        $docBackPath = $data['doc_back_path'] ?? null;
        return view('user.loan.documents', compact('docFrontPath', 'docBackPath'));
    }

    // Documents step: store (session-backed)
    public function documentsStore(Request $request)
    {
        $validated = $request->validate([
            'doc_type' => ['required', 'in:nid,passport,driving_licence'],
            'doc_front' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'doc_back' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);
        $data = $request->session()->get('loan_apply');
        if (!$data || ($data['user_id'] ?? null) !== $request->user()->id) {
            return redirect()->route('user.loan.apply')->with('error', 'প্রথমে আবেদন শুরু করুন।');
        }

        $data['doc_type'] = $validated['doc_type'];
        if ($request->hasFile('doc_front')) {
            $data['doc_front_path'] = $request->file('doc_front')->store('loan-docs', 'public');
        }
        if ($request->hasFile('doc_back')) {
            $data['doc_back_path'] = $request->file('doc_back')->store('loan-docs', 'public');
        } else {
            $data['doc_back_path'] = null;
        }
        $request->session()->put('loan_apply', $data);

        return redirect()->route('user.loan.deposit.form')->with('status', 'ডকুমেন্ট আপলোড সম্পন্ন, এখন জামানত জমা দিন।');
    }

    // Deposit step: form (session-backed)
    public function depositForm(Request $request)
    {
        $data = $request->session()->get('loan_apply');
        if (!$data || ($data['user_id'] ?? null) !== $request->user()->id) {
            return redirect()->route('user.loan.apply')->with('error', 'প্রথমে আবেদন শুরু করুন।');
        }
        $gateways = Gateway::where('type', 'deposit')->where('status', 'active')->get();
        $depositRequired = $data['deposit_required_amount'] ?? 0;
        return view('user.loan.deposit', compact('gateways', 'depositRequired'));
    }

    // Deposit step: store -> finally persist to DB and clear session
    public function depositStore(Request $request)
    {
        $validated = $request->validate([
            'gateway_id' => ['required', 'exists:gateways,id'],
            'transaction_id' => ['required', 'string', 'max:255'],
            'screenshot' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        $data = $request->session()->get('loan_apply');
        if (!$data || ($data['user_id'] ?? null) !== $request->user()->id) {
            return redirect()->route('user.loan.apply')->with('error', 'প্রথমে আবেদন শুরু করুন।');
        }

        $gateway = Gateway::findOrFail($validated['gateway_id']);

        // Persist final Loan record
        $loan = Loan::create([
            'user_id' => $data['user_id'],
            'amount_value' => $data['amount_value'] ?? null,
            'amount_label' => $data['amount_label'] ?? null,
            'duration_value' => $data['duration_value'] ?? null,
            'duration_label' => $data['duration_label'] ?? null,
            'reason_value' => $data['reason_value'] ?? null,
            'reason_label' => $data['reason_label'] ?? null,
            'principal' => $data['principal'] ?? null,
            'duration_months' => $data['duration_months'] ?? null,
            'interest_rate' => $data['interest_rate'] ?? null,
            'interest_amount' => $data['interest_amount'] ?? null,
            'total_payable' => $data['total_payable'] ?? null,
            'monthly_installment' => $data['monthly_installment'] ?? null,
            'deposit_required_amount' => $data['deposit_required_amount'] ?? null,
            'doc_type' => $data['doc_type'] ?? null,
            'doc_front_path' => $data['doc_front_path'] ?? null,
            'doc_back_path' => $data['doc_back_path'] ?? null,
            'status' => 'pending',
        ]);

        // Deposit info
        $loan->deposit_gateway_id = $gateway->id;
        $loan->deposit_account_number = $gateway->account_number;
        $loan->deposit_transaction_id = $validated['transaction_id'];
        if ($request->hasFile('screenshot')) {
            $loan->deposit_screenshot_path = $request->file('screenshot')->store('loan-deposits', 'public');
        }
        $loan->deposit_submitted_at = now();
        $loan->save();

        // Clear session payload to avoid duplicates
        $request->session()->forget('loan_apply');

        return redirect()->route('user.dashboard')->with('status', 'জামানত জমা দেওয়া হয়েছে, আপনার আবেদন প্রশাসনিক পর্যালোচনায় আছে।');
    }

    private function authorizeLoan(Request $request, Loan $loan): void
    {
        abort_unless($loan->user_id === $request->user()->id, 403);
    }
}
