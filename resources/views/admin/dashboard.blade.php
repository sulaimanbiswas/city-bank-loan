@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="/admin/dashboard" class="flex items-center gap-2">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>

            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                Dashboard</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <div class=" space-y-5">
        <div class="grid grid-cols-12 gap-5 mb-5">

            <div class="col-span-12">
                <div class="grid md:grid-cols-4 grid-cols-1 gap-4">

                    <!-- BEGIN: Group Chart -->


                    <div class="card">
                        <div class="card-body pt-4 pb-3 px-4">
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none">
                                    <div
                                        class="h-12 w-12 rounded-full flex flex-col items-center justify-center text-2xl bg-[#E5F9FF] dark:bg-slate-900	 text-info-500">
                                        <iconify-icon icon=heroicons:users></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-600 dark:text-slate-300 text-sm mb-1 font-medium">
                                        Users
                                    </div>
                                    <div class="text-slate-900 dark:text-white text-lg font-medium">
                                        3,564
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body pt-4 pb-3 px-4">
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none">
                                    <div
                                        class="h-12 w-12 rounded-full flex flex-col items-center justify-center text-2xl bg-[#FFEDE6] dark:bg-slate-900	 text-warning-500">
                                        <iconify-icon icon=heroicons:currency-dollar></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-600 dark:text-slate-300 text-sm mb-1 font-medium">
                                        User Balance
                                    </div>
                                    <div class="text-slate-900 dark:text-white text-lg font-medium">
                                        ৳ 564
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body pt-4 pb-3 px-4">
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none">
                                    <div
                                        class="h-12 w-12 rounded-full flex flex-col items-center justify-center text-2xl bg-[#EAE6FF] dark:bg-slate-900	 text-[#5743BE]">
                                        <iconify-icon icon=heroicons:check-circle></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-600 dark:text-slate-300 text-sm mb-1 font-medium">
                                        Approved Loans (1)
                                    </div>
                                    <div class="text-slate-900 dark:text-white text-lg font-medium">
                                        +5.0%
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body pt-4 pb-3 px-4">
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none">
                                    <div
                                        class="h-12 w-12 rounded-full flex flex-col items-center justify-center text-2xl bg-[#EAE6FF] dark:bg-slate-900	 text-[#5743BE]">
                                        <iconify-icon icon=heroicons:document-currency-pound></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-slate-600 dark:text-slate-300 text-sm mb-1 font-medium">
                                        Deposit (1)
                                    </div>
                                    <div class="text-slate-900 dark:text-white text-lg font-medium">
                                        +5.0%
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- END: Group Chart -->
                </div>
            </div>
        </div>
    </div>
@endsection
