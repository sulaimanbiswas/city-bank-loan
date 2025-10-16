@extends('layouts.admin')

@section('title', 'Users')

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
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Users</li>
        </ul>
    </div>
    <div class="space-y-4">

        @if (session('status'))
            <div class="p-2 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title">Users
                </h4>
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                    <div class="input-area">
                        <div class="relative">
                            <input type="text" name="q" class="form-control !pr-12" value="{{ request('q') }}"
                                placeholder="Search">
                            <button
                                class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </form>
            </header>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6 dashcode-data-table">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden min-h-[300px]">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700"
                                id="data-table">
                                <thead class=" border-t border-slate-100 dark:border-slate-800">
                                    <tr>
                                        <th scope="col" class=" table-th ">
                                            Id
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Name
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Phone Number
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Email
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Balance
                                        </th>

                                        <th scope="col" class=" table-th ">
                                            Plan
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Status
                                        </th>
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Type
                                        </th>
                                        <th scope="col" class=" table-th ">
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700 min-h-[500px]">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="table-td">{{ $user->id }}</td>
                                            <td class="table-td">{{ $user->name }}</td>
                                            <td class="table-td ">{{ $user->phone }}</td>
                                            <td class="table-td normal-case">{{ $user->email }}</td>
                                            <td class="table-td ">
                                                <div>
                                                    ${{ number_format($user->balance ?? 0, 2) }}
                                                </div>
                                            </td>
                                            <td class="table-td normal-case">{{ $user->current_plan ?? '-' }}</td>
                                            <td class="table-td ">

                                                <div
                                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25  @if ($user->status === 'active') text-success-500 bg-success-500 @else text-warning-500 bg-warning-500 @endif">
                                                    {{ ucfirst($user->status) }}
                                                </div>

                                            </td>
                                            <td class="table-td normal-case">{{ ucfirst($user->user_type) }}</td>
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
                                                                    <form method="POST"
                                                                        action="{{ route('admin.users.impersonate', $user) }}"
                                                                        class="flex items-center hover:bg-slate-100 w-full dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="country-list flex items-start w-full px-4 py-2">
                                                                            <iconify-icon
                                                                                class="text-lg text-textColor dark:text-white mr-2"
                                                                                icon="mynaui:external-link">
                                                                            </iconify-icon>
                                                                            <span class="dropdown-option">
                                                                                Login as
                                                                            </span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('admin.users.toggle', $user) }}"
                                                                        class="flex items-center hover:bg-slate-100 w-full dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="country-list flex items-start w-full px-4 py-2">
                                                                            <iconify-icon
                                                                                class="text-lg text-textColor dark:text-white mr-2"
                                                                                icon="{{ $user->status === 'active' ? 'lucide:user-x' : 'lucide:user-check' }}">
                                                                            </iconify-icon>
                                                                            <span class="dropdown-option">
                                                                                {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                                            </span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                                        class="flex items-center px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        <iconify-icon
                                                                            class="text-lg text-textColor dark:text-white mr-2"
                                                                            icon="prime:user-edit">
                                                                        </iconify-icon>
                                                                        <span class="dropdown-option">
                                                                            Edit
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('admin.users.destroy', $user) }}"
                                                                        onsubmit="return confirm('Delete this user?')"
                                                                        class="flex items-center hover:bg-slate-100 w-full dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                                        @csrf
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
                                            <td colspan="9" class="text-center p-4 text-sm text-gray-500">
                                                No users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
