@extends('layouts.app')

@section('title', 'প্রোফাইল')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="p-4 sm:p-6 bg-white shadow rounded">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form', ['user' => $user])
            </div>
        </div>
        <div class="p-4 sm:p-6 bg-white shadow rounded">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        <div class="p-4 sm:p-6 bg-white shadow rounded">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    @if (session('status') === 'profile-updated')
    <div class="mt-4 text-green-600 text-sm">প্রোফাইল আপডেট হয়েছে।</div>
    @endif
</div>
@endsection