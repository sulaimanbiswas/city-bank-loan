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


        </div>
    </div>
@endsection
