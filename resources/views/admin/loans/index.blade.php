@extends('layouts.admin')

@section('title', 'Loans')

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
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Loans</li>
        </ul>
    </div>

    <div class="space-y-4">
        @if (session('status'))
            <div class="py-[18px] px-6 font-normal text-sm rounded-md bg-primary-500 bg-opacity-[14%]  text-white">
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

        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title">Loans</h4>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('admin.loans.index') }}" class="flex items-center gap-2">
                        <div class="input-area">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                            </select>
                        </div>
                        <div class="input-area">
                            <div class="relative">
                                <input type="text" name="q" class="form-control !pr-12" value="{{ request('q') }}"
                                    placeholder="Search by user name">
                                <button
                                    class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                    <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </header>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden min-h-[300px] flex flex-col justify-between">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                <thead class=" border-t border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th class="table-th">ID</th>
                                        <th class="table-th">User</th>
                                        <th class="table-th">Amount</th>
                                        <th class="table-th">Duration</th>
                                        <th class="table-th">Reason</th>
                                        <th class="table-th">Interest</th>
                                        <th class="table-th">Status</th>
                                        <th class="table-th">Submitted</th>
                                        <th class="table-th">Action</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700 min-h-[300px]">
                                    @forelse ($loans as $loan)
                                        <tr>
                                            <td class="table-td">{{ $loan->id }}</td>
                                            <td class="table-td">{{ $loan->user?->name }}</td>
                                            <td class="table-td">{{ $loan->amount_label ?? $loan->amount_value }}</td>
                                            <td class="table-td">{{ $loan->duration_label ?? $loan->duration_value }}</td>
                                            <td class="table-td">{{ $loan->reason_label ?? $loan->reason_value }}</td>
                                            <td class="table-td">
                                                @if (!is_null($loan->interest_amount))
                                                    <div class="text-sm">Rate:
                                                        {{ number_format($loan->interest_rate ?? 0, 2) }}%</div>
                                                    <div class="text-sm">Int:
                                                        {{ number_format($loan->interest_amount, 2) }}</div>
                                                    <div class="text-sm">Total:
                                                        {{ number_format($loan->total_payable ?? 0, 2) }}</div>
                                                    <div class="text-sm">EMI:
                                                        {{ number_format($loan->monthly_installment ?? 0, 2) }}</div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="table-td">
                                                <div
                                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25  @if ($loan->status === 'approved') text-success-500 bg-success-500 @elseif($loan->status === 'rejected') text-danger-500 bg-danger-500 @else text-warning-500 bg-warning-500 @endif">
                                                    {{ ucfirst($loan->status) }}
                                                </div>
                                            </td>
                                            <td class="table-td">{{ $loan->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="table-td">
                                                <a href="{{ route('admin.loans.show', $loan) }}"
                                                    class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center p-4 text-sm text-gray-500">No loans found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-6 px-6">{{ $loans->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
