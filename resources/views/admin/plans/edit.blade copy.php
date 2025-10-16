@extends('layouts.admin')
@section('title', 'Edit Plan')

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
        <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
            <a href="{{ route('admin.plans.index') }}" class="flex items-center gap-2">
                Plans
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
            </a>
        </li>
        <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
            Edit Plan
        </li>
    </ul>
</div>
<div class="space-y-5">
    <div class="card">
        <header class="card-header">
            <h4 class="card-title">Edit Plan</h4>
        </header>
        <div class="card-body">
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

            <form method="PATCH" action="{{ route('admin.plans.update', $plan) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                {{-- Plan Name --}}
                <div class="input-area relative pl-28">
                    <label for="name" class="inline-inputLabel">Name</label>
                    <div class="relative">
                        <input id="name" type="text" name="name" class="form-control !pl-9"
                            value="{{ old('name', $plan->name) }}" required>
                        <iconify-icon icon="heroicons-outline:document-text"
                            class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                    </div>
                </div>

                {{-- Plan Label --}}
                <div class="input-area relative pl-28">
                    <label for="label" class="inline-inputLabel">Label</label>
                    <div class="relative">
                        <input id="label" type="text" name="label" class="form-control !pl-9"
                            value="{{ old('label', $plan->label) }}">
                        <iconify-icon icon="heroicons-outline:tag"
                            class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                    </div>
                </div>

                {{-- Plan Type (Radio Buttons) --}}
                <div class="input-area relative pl-28">
                    <label class="inline-inputLabel">Type</label>
                    <div class="flex items-center space-x-4">
                        @php($opts = ['amount', 'duration', 'reason'])
                        @foreach ($opts as $opt)
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="type" value="{{ $opt }}" class="hidden peer"
                                {{-- Check if the old input or the existing plan type matches the current option --}}
                                {{ old('type', $plan->types ?? '') == $opt ? 'checked' : '' }}>
                            <span
                                class="h-4 w-4 rounded-full border border-slate-400 peer-checked:bg-slate-900 peer-checked:border-slate-900 transition-all duration-150 relative">
                                {{-- This image will appear inside the circle when selected --}}
                                <img src="/images/icon/ck-white.svg" alt=""
                                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100">
                            </span>
                            <span
                                class="text-slate-500 dark:text-slate-400 text-sm leading-6 capitalize ml-2">{{ $opt }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Plan Value --}}
                <div class="input-area relative pl-28">
                    <label for="value" class="inline-inputLabel">Value</label>
                    <div class="relative">
                        <input id="value" type="text" name="value" class="form-control !pl-9"
                            value="{{ old('value', $plan->value) }}">
                        <iconify-icon icon="heroicons-outline:currency-dollar"
                            class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                    </div>
                </div>

                {{-- Interest Rate --}}
                <div class="input-area relative pl-28">
                    <label for="interest_rate" class="inline-inputLabel">Interest Rate (%)</label>
                    <div class="relative">
                        <input id="interest_rate" type="number" step="0.01" name="interest_rate"
                            class="form-control !pl-9" value="{{ old('interest_rate', $plan->interest_rate) }}"
                            required>
                        <iconify-icon icon="heroicons-outline:receipt-percent"
                            class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                    </div>
                </div>

                {{-- Status --}}
                <div class="input-area relative pl-28">
                    <label for="status" class="inline-inputLabel">Status</label>
                    <div class="relative">
                        <select id="status" name="status" class="form-select !pl-9">
                            <option value="active" @selected(old('status', $plan->status) === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $plan->status) === 'inactive')>Inactive</option>
                        </select>
                        <iconify-icon icon="heroicons-outline:check-circle"
                            class="absolute left-2 top-1/2 -translate-y-1/2 text-base text-slate-500"></iconify-icon>
                    </div>
                </div>

                <div class="pl-28 flex items-center gap-4">
                    <button type="submit" class="btn inline-flex justify-center btn-dark">Save</button>
                    <a href="{{ route('admin.plans.index') }}"
                        class="btn inline-flex justify-center btn-outline-dark">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection