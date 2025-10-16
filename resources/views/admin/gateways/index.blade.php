@extends('layouts.admin')

@section('title', 'Gateways')

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
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Gateways</li>
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
                <h4 class="card-title">Gateways</h4>
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('admin.gateways.index') }}" class="flex items-center gap-2">
                        <div class="input-area">
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                <option value="deposit" @selected(request('type') === 'deposit')>Deposit</option>
                                <option value="withdraw" @selected(request('type') === 'withdraw')>Withdraw</option>
                            </select>
                        </div>
                        <div class="input-area">
                            <div class="relative">
                                <input type="text" name="q" class="form-control !pr-12" value="{{ request('q') }}"
                                    placeholder="Search method">
                                <button
                                    class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                    <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                                </button>
                            </div>
                        </div>

                    </form>
                    <a href="{{ route('admin.gateways.create') }}">
                        <button class="btn inline-flex justify-center btn-sm btn-outline-dark ">
                            <span class="flex items-center">
                                <iconify-icon class="text-2xl ltr:mr-2 rtl:ml-2" icon="ic:round-plus"></iconify-icon>
                                <span>Create Gateway</span>
                            </span>
                        </button>
                    </a>
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
                                        <th class="table-th">Type</th>
                                        <th class="table-th">Method</th>
                                        <th class="table-th">Account</th>
                                        <th class="table-th">Logo</th>
                                        <th class="table-th">Status</th>
                                        <th class="table-th">Action</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700 min-h-[300px]">
                                    @forelse ($gateways as $gateway)
                                        <tr>
                                            <td class="table-td">{{ $gateway->id }}</td>
                                            <td class="table-td capitalize">{{ $gateway->type }}</td>
                                            <td class="table-td">{{ $gateway->method }}</td>
                                            <td class="table-td">{{ $gateway->account_number ?? '-' }}</td>
                                            <td class="table-td">
                                                @if ($gateway->logo_url)
                                                    <img src="{{ $gateway->logo_url }}" alt="logo"
                                                        class="h-8 w-8 object-contain rounded" />
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="table-td">
                                                <div
                                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25  @if ($gateway->status === 'active') text-success-500 bg-success-500 @else text-warning-500 bg-warning-500 @endif">
                                                    {{ ucfirst($gateway->status) }}
                                                </div>
                                            </td>
                                            <td class="table-td ">
                                                <div>
                                                    <div class="relative">
                                                        <div class="dropdown relative">
                                                            <button class="text-xl text-center block w-full " type="button"
                                                                id="tableDropdownMenuButton1" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <iconify-icon
                                                                    icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                            </button>
                                                            <ul
                                                                class="absolute dropdown-menu min-w-[120px]  text-sm text-slate-700 dark:text-white hidden bg-white dark:bg-slate-700 shadow z-[2] float-left overflow-hidden list-none text-left rounded-lg mt-1 m-0 bg-clip-padding border-none">
                                                                <li>
                                                                    <a href="{{ route('admin.gateways.edit', $gateway) }}"
                                                                        class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        <iconify-icon
                                                                            class="text-lg text-textColor dark:text-white mr-2"
                                                                            icon="basil:edit-outline">
                                                                        </iconify-icon>
                                                                        <span class="dropdown-option">
                                                                            Edit
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('admin.gateways.toggle', $gateway) }}"
                                                                        class="flex items-center hover:bg-slate-100 w-full dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="country-list flex items-start w-full px-4 py-2">
                                                                            <iconify-icon
                                                                                class="text-lg text-textColor dark:text-white mr-2"
                                                                                icon="{{ $gateway->status === 'active' ? 'nrk:close-active' : 'nrk:check-active' }}">
                                                                            </iconify-icon>
                                                                            <span class="dropdown-option">
                                                                                {{ $gateway->status === 'active' ? 'Inactive' : 'Activate' }}
                                                                            </span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('admin.gateways.destroy', $gateway) }}"
                                                                        onsubmit="return confirm('Delete this gateway?')"
                                                                        class="flex items-center hover:bg-slate-100 w-full dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="country-list flex items-start w-full px-4 py-2">
                                                                            <iconify-icon
                                                                                class="text-lg text-textColor dark:text-white mr-2"
                                                                                icon="material-symbols-light:delete-outline">
                                                                            </iconify-icon>
                                                                            <span class="dropdown-option">
                                                                                Delete
                                                                            </span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center p-4 text-sm text-gray-500">No gateways
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-6 px-6">{{ $gateways->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
