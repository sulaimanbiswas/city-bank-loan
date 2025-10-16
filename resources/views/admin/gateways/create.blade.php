@extends('layouts.admin')

@section('title', 'Create Gateway')

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
            <li class="inline-block relative text-sm text-primary-500 font-Inter ">
                <a href="{{ route('admin.gateways.index') }}">Gateways</a>
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">Create Gateway</li>
        </ul>
    </div>

    <div class=" space-y-5">
        @if ($errors->any())
            <div class="py-[18px] px-6 font-normal text-sm rounded-md bg-danger-500 bg-opacity-[14%]  text-white">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <iconify-icon class="text-2xl flex-0 text-danger-500" icon="ic:twotone-error"></iconify-icon>
                    <p class="flex-1 text-danger-500 font-Inter">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                    <div class="flex-0 text-xl cursor-pointer text-danger-500"
                        onclick="this.parentElement.parentElement.style.display='none';">
                        <iconify-icon icon="line-md:close"></iconify-icon>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-5 mb-5">
            <div class="card col-span-12 lg:col-span-12">
                <div class="card-body flex flex-col p-6">
                    <header class="flex items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Create Gateway</div>
                        </div>
                    </header>
                    <div class="card-text h-full">
                        <form class="space-y-4" method="POST" action="{{ route('admin.gateways.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                <div class="input-area">
                                    <label class="form-label">Type</label>
                                    <select name="type" class="form-control" id="gw_type">
                                        <option value="deposit" @selected(old('type') === 'deposit')>Deposit</option>
                                        <option value="withdraw" @selected(old('type') === 'withdraw')>Withdraw</option>
                                    </select>
                                </div>
                                <div class="input-area">
                                    <label class="form-label">Gateway Method</label>
                                    <input type="text" name="method" value="{{ old('method') }}" class="form-control"
                                        placeholder="e.g., bKash, Nagad" required>
                                </div>
                                <div class="input-area" id="account_wrap">
                                    <label class="form-label">Account Number (for Deposit)</label>
                                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                                        class="form-control" placeholder="Account number">
                                </div>

                                <div class="input-area">
                                    <label class="form-label">Logo </label>
                                    <div class="filegroup">
                                        <label>
                                            <input type="file" name="logo" accept="image/*" class="w-full hidden"
                                                name="basic">
                                            <span class="w-full h-[40px] file-control flex items-center custom-class">
                                                <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                                    <span class="text-slate-400">Choose a file or drop it here...</span>
                                                </span>
                                                <span
                                                    class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label
                                        class="relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                        <input type="hidden" name="status" value="inactive">
                                        <input type="checkbox" name="status" value="active" class="sr-only peer"
                                            {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                                        <span
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-black-500"></span>
                                    </label>
                                    <span class="text-sm text-slate-600 font-Inter font-normal">Active</span>
                                </div>
                            </div>

                            <button class="btn inline-flex justify-center btn-dark">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleAccount() {
                const type = document.getElementById('gw_type').value;
                const wrap = document.getElementById('account_wrap');
                if (type === 'deposit') {
                    wrap.style.display = '';
                } else {
                    wrap.style.display = 'none';
                }
            }
            document.getElementById('gw_type').addEventListener('change', toggleAccount);
            toggleAccount();
        </script>
    @endpush
@endsection
