<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $status = (string) $request->string('status');
        $q = (string) $request->string('q');

        $loans = Loan::query()
            ->with(['user', 'depositGateway'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn($q2) => $q2->where('status', $status))
            ->when($q, function ($q2) use ($q) {
                $q2->whereHas('user', function ($uq) use ($q) {
                    $uq->where('name', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'processor', 'depositGateway']);
        return view('admin.loans.show', compact('loan'));
    }

    public function approve(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Only pending loans can be approved.');
        }

        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        // Credit user's balance with the approved loan principal amount
        if (!is_null($loan->principal) && $loan->principal > 0 && $loan->user) {
            $loan->user()->increment('balance', $loan->principal);
        }

        $loan->status = 'approved';
        $loan->admin_note = $data['admin_note'] ?? $loan->admin_note;
        $loan->processed_by = $request->user()->id;
        $loan->processed_at = now();
        $loan->save();

        return redirect()->route('admin.loans.show', $loan)->with('status', 'Loan approved successfully');
    }

    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Only pending loans can be rejected.');
        }

        $data = $request->validate([
            'admin_note' => ['required', 'string', 'max:2000'],
        ]);

        $loan->status = 'rejected';
        $loan->admin_note = $data['admin_note'];
        $loan->processed_by = $request->user()->id;
        $loan->processed_at = now();
        $loan->save();

        return redirect()->route('admin.loans.show', $loan)->with('status', 'Loan rejected successfully');
    }
}
