@extends('layouts.admin')

@section('title', 'Edit User')

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
                Edit User</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <div class=" space-y-5">
        <div class="grid grid-cols-12 gap-5 mb-5">
            <div class="card col-span-12 lg:col-span-12">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Edit User</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline">View Details</a>
                        </div>
                    </header>
                    <div class="card-text h-full ">
                        @if ($errors->any())
                            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                                <div class="font-semibold mb-1">Please fix the following:</div>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="space-y-4" method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PATCH')
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Full Name</label>
                                <div class="relative">
                                    <input type="text" class="form-control !pl-9" name="name"
                                        value="{{ old('name', $user->name) }}" placeholder="Full Name">
                                    <iconify-icon icon="heroicons-outline:user"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                                </div>
                                @error('name')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Email</label>
                                <div class="relative">
                                    <input type="email" class="form-control !pl-9" name="email"
                                        value="{{ old('email', $user->email) }}" placeholder="Email Address">
                                    <iconify-icon icon="heroicons-outline:mail"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                                </div>
                                @error('email')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Phone</label>
                                <div class="relative">
                                    <input type="tel" class="form-control !pl-9" placeholder="Phone Number"
                                        name="phone" value="{{ old('phone', $user->phone) }}">
                                    <iconify-icon icon="heroicons-outline:phone"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                                </div>
                                @error('phone')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Hidden fields to satisfy controller validation and preserve existing values -->
                            <input type="hidden" name="status" value="{{ old('status', $user->status) }}" />
                            <input type="hidden" name="user_type" value="{{ old('user_type', $user->user_type) }}" />
                            <input type="hidden" name="balance" value="{{ old('balance', $user->balance) }}" />

                            <button class="btn inline-flex justify-center btn-dark ml-28">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
