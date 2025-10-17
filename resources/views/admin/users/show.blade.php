@extends('layouts.admin')

@section('title', 'User Details')

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
            <li class="inline-block relative text-sm text-slate-500 font-Inter">User Details</li>
        </ul>
    </div>

    <div class="space-y-5">
        <div class="grid grid-cols-12 gap-5 mb-5">
            <div class="card col-span-12 lg:col-span-12">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $user->email }} • {{ $user->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline">Edit</a>
                        </div>
                    </header>
                    <div class="card-text h-full ">
                        @if (session('status'))
                            <div class="p-2 bg-green-100 text-green-800 rounded mb-4">{{ session('status') }}</div>
                        @endif

                        @isset($loanSummary)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4 rounded border border-slate-200 dark:border-slate-700">
                                    <div class="text-xs text-slate-500">মোট লোন</div>
                                    <div class="text-lg font-semibold">
                                        ৳{{ number_format($loanSummary['total_principal'] ?? 0, 2) }}</div>
                                </div>
                                <div class="p-4 rounded border border-slate-200 dark:border-slate-700">
                                    <div class="text-xs text-slate-500">মাসিক কিস্তি (EMI)</div>
                                    <div class="text-lg font-semibold">৳{{ number_format($loanSummary['monthly_emi'] ?? 0, 2) }}
                                    </div>
                                </div>
                                <div class="p-4 rounded border border-slate-200 dark:border-slate-700">
                                    <div class="text-xs text-slate-500">বাকি</div>
                                    <div class="text-lg font-semibold">৳{{ number_format($loanSummary['remaining'] ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>
                        @endisset

                        <div class="mt-6">
                            <h3 class="text-sm font-semibold mb-3">Recent Loans</h3>
                            <div class="overflow-x-auto -mx-6 dashcode-data-table">
                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-hidden">
                                        <table
                                            class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                            <thead class=" border-t border-slate-100 dark:border-slate-800">
                                                <tr>
                                                    <th class="table-th">ID</th>
                                                    <th class="table-th">Principal</th>
                                                    <th class="table-th">Duration</th>
                                                    <th class="table-th">Rate</th>
                                                    <th class="table-th">Monthly EMI</th>
                                                    <th class="table-th">Total Payable</th>
                                                    <th class="table-th">Status</th>
                                                    <th class="table-th">Applied</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                                @forelse($loans as $loan)
                                                    <tr>
                                                        <td class="table-td">{{ $loan->id }}</td>
                                                        <td class="table-td">৳{{ number_format($loan->principal, 2) }}</td>
                                                        <td class="table-td">{{ $loan->duration_months }} mo</td>
                                                        <td class="table-td">
                                                            {{ rtrim(rtrim(number_format($loan->interest_rate, 2), '0'), '.') }}%
                                                        </td>
                                                        <td class="table-td">
                                                            ৳{{ number_format($loan->monthly_installment, 2) }}</td>
                                                        <td class="table-td">৳{{ number_format($loan->total_payable, 2) }}
                                                        </td>
                                                        <td class="table-td">
                                                            <span
                                                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25  @if ($loan->status === 'approved') text-success-500 bg-success-500 @elseif($loan->status === 'pending') text-warning-500 bg-warning-500 @else text-red-500 bg-red-500 @endif">
                                                                {{ ucfirst($loan->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="table-td">{{ $loan->created_at?->format('d M Y') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center p-4 text-sm text-gray-500">No
                                                            loans found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
