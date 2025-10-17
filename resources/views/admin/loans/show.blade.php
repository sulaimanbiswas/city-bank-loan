@extends('layouts.admin')

@section('title', 'Loan Details')

@section('content')
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter"><a
                    href="{{ route('admin.loans.index') }}">Loans</a></li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter">#{{ $loan->id }}</li>
        </ul>
    </div>

    @if (session('status'))
        <div class="py-[18px] px-6 font-normal text-sm rounded-md bg-primary-500 bg-opacity-[14%]  text-white mb-4">
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <iconify-icon class="text-2xl flex-0 text-primary-500" icon="ic:twotone-error"></iconify-icon>
                <p class="flex-1 text-primary-500 font-Inter">{{ session('status') }}</p>
                <div class="flex-0 text-xl cursor-pointer text-primary-500"
                    onclick="this.parentElement.parentElement.style.display='none';">
                    <iconify-icon icon="line-md:close"></iconify-icon>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="py-[18px] px-6 font-normal text-sm rounded-md bg-red-500 bg-opacity-[14%] text-white mb-4">
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <iconify-icon class="text-2xl flex-0 text-red-500" icon="material-symbols:error"></iconify-icon>
                <p class="flex-1 text-red-500 font-Inter">{{ session('error') }}</p>
                <div class="flex-0 text-xl cursor-pointer text-red-500"
                    onclick="this.parentElement.parentElement.style.display='none';">
                    <iconify-icon icon="line-md:close"></iconify-icon>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <header class="card-header noborder">
                    <h4 class="card-title">Loan Information</h4>
                </header>
                <div class="card-body p-6 space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-slate-500">User</div>
                            <div class="font-medium">{{ $loan->user?->name }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Status</div>
                            <div class="font-medium capitalize">{{ $loan->status }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Amount</div>
                            <div class="font-medium">{{ $loan->amount_label ?? $loan->amount_value }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Duration (months)</div>
                            <div class="font-medium">{{ $loan->duration_label ?? $loan->duration_value }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Reason</div>
                            <div class="font-medium">{{ $loan->reason_label ?? $loan->reason_value }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Interest Rate</div>
                            <div class="font-medium">
                                ৳{{ is_null($loan->interest_rate) ? '-' : number_format($loan->interest_rate, 2) . '%' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Interest Amount</div>
                            <div class="font-medium">
                                ৳{{ is_null($loan->interest_amount) ? '-' : number_format($loan->interest_amount, 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Total Payable</div>
                            <div class="font-medium">
                                ৳{{ is_null($loan->total_payable) ? '-' : number_format($loan->total_payable, 2) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Monthly Installment</div>
                            <div class="font-medium">
                                ৳{{ is_null($loan->monthly_installment) ? '-' : number_format($loan->monthly_installment, 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Submitted</div>
                            <div class="font-medium">{{ $loan->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>

                    @if ($loan->processed_at)
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <div class="text-xs text-slate-500">Processed By</div>
                                <div class="font-medium">{{ $loan->processor?->name ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">Processed At</div>
                                <div class="font-medium">{{ $loan->processed_at?->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                    @endif

                    @if ($loan->admin_note)
                        <div class="pt-2">
                            <div class="text-xs text-slate-500">Admin Note</div>
                            <div class="font-medium">{{ $loan->admin_note }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mt-6">
                <header class="card-header noborder">
                    <h4 class="card-title">Documents & Deposit</h4>
                </header>
                <div class="card-body p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-slate-500">Document Type</div>
                            <div class="font-medium capitalize">{{ $loan->doc_type ?? '-' }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-xs text-slate-500 mb-1">Document Preview</div>
                            <div class="flex items-center gap-4">
                                @if ($loan->doc_front_path)
                                    <img src="{{ asset('storage/' . $loan->doc_front_path) }}"
                                        class="h-24 w-40 object-contain border rounded" />
                                @endif
                                @if ($loan->doc_back_path)
                                    <img src="{{ asset('storage/' . $loan->doc_back_path) }}"
                                        class="h-24 w-40 object-contain border rounded" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="text-xs text-slate-500">Gateway</div>
                            <div class="flex items-center gap-2">
                                @if ($loan->depositGateway && $loan->depositGateway->logo_url)
                                    <img src="{{ $loan->depositGateway->logo_url }}" class="h-4 w-4 object-contain rounded"
                                        alt="gateway logo" />
                                @endif
                                <div class="font-medium">
                                    @if ($loan->depositGateway)
                                        {{ $loan->depositGateway->method }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Deposit Required</div>
                            <div class="font-medium">
                                ৳{{ is_null($loan->deposit_required_amount) ? '-' : number_format($loan->deposit_required_amount, 2) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Account</div>
                            <div class="font-medium">{{ $loan->deposit_account_number ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Transaction ID</div>
                            <div class="font-medium break-all">{{ $loan->deposit_transaction_id ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Deposit Submitted</div>
                            <div class="font-medium">
                                {{ $loan->deposit_submitted_at ? $loan->deposit_submitted_at->format('Y-m-d H:i') : '-' }}
                            </div>
                        </div>
                        @if ($loan->deposit_screenshot_path)
                            <div class="col-span-2">
                                <div class="text-xs text-slate-500 mb-1">Screenshot</div>
                                <img src="{{ asset('storage/' . $loan->deposit_screenshot_path) }}"
                                    class="h-48 object-contain border rounded" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div>

            <div class="card">
                <header class="card-header noborder">
                    <h4 class="card-title">Process</h4>
                </header>
                <div class="card-body p-6 space-y-4">
                    @if ($loan->status === 'pending')
                        <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="space-y-3"
                            onsubmit="return confirm('Are you sure you want to approve this loan?');">
                            @csrf
                            <div class="input-area">
                                <label class="form-label">Note (optional)</label>
                                <textarea name="admin_note" class="form-control" rows="3" placeholder="Approval note (optional)"></textarea>
                            </div>
                            <button class="btn btn-success w-full">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="space-y-3"
                            onsubmit="return confirm('Are you sure you want to reject this loan?');">
                            @csrf
                            <div class="input-area">
                                <label class="form-label">Note (required)</label>
                                <textarea name="admin_note" class="form-control" rows="3" placeholder="Reason for rejection" required></textarea>
                            </div>
                            <button class="btn btn-danger w-full">Reject</button>
                        </form>
                    @else
                        <div class="text-sm text-slate-600">This loan has been {{ $loan->status }}.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
