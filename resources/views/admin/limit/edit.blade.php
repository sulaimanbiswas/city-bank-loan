@extends('layouts.admin')

@section('title', 'Limit Settings')

@section('content')
    <!-- BEGIN: Breadcrumb -->
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
                Settings
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Limit Settings</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->

    <div class=" space-y-5">
        @if (session('status'))
            <div class="py-[18px] px-6 font-normal text-sm rounded-md bg-primary-500 bg-opacity-[14%]  text-white">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <iconify-icon class="text-2xl flex-0 text-primary-500" icon="ic:twotone-error"></iconify-icon>
                    <p class="flex-1 text-primary-500 font-Inter">
                        {{ session('status') }}
                    </p>
                    <div class="flex-0 text-xl cursor-pointer text-primary-500"
                        onclick="this.parentElement.parentElement.style.display='none';">
                        <iconify-icon icon="line-md:close"></iconify-icon>
                    </div>
                </div>
            </div>
        @endif

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
                            <div class="card-title text-slate-900 dark:text-white">Limit Settings</div>
                        </div>
                    </header>
                    <div class="card-text h-full">
                        <form class="space-y-4" method="POST" action="{{ route('admin.limit.update') }}">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                <div class="input-area relative ">
                                    <label class="form-label">Minimum Deposit</label>
                                    <input type="number" step="0.01" min="0" name="min_deposit"
                                        value="{{ old('min_deposit', $limit->min_deposit) }}" class="form-control"
                                        placeholder="0.00">
                                </div>
                                <div class="input-area relative ">
                                    <label class="form-label">Maximum Deposit</label>
                                    <input type="number" step="0.01" min="0" name="max_deposit"
                                        value="{{ old('max_deposit', $limit->max_deposit) }}" class="form-control"
                                        placeholder="0.00">
                                </div>
                                <div class="input-area relative ">
                                    <label class="form-label">Minimum Withdraw</label>
                                    <input type="number" step="0.01" min="0" name="min_withdraw"
                                        value="{{ old('min_withdraw', $limit->min_withdraw) }}" class="form-control"
                                        placeholder="0.00">
                                </div>
                                <div class="input-area relative ">
                                    <label class="form-label">Maximum Withdraw</label>
                                    <input type="number" step="0.01" min="0" name="max_withdraw"
                                        value="{{ old('max_withdraw', $limit->max_withdraw) }}" class="form-control"
                                        placeholder="0.00">
                                </div>
                            </div>

                            <button class="btn inline-flex justify-center btn-dark">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
