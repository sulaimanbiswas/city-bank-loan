@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-2xl">
        <h1 class="text-xl font-semibold mb-4">Edit User</h1>

        @if ($errors->any())
            <div class="p-2 bg-red-100 text-red-800 rounded mb-3">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-3">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input w-full">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Balance</label>
                    <input type="number" step="0.01" name="balance" value="{{ old('balance', $user->balance) }}"
                        class="form-input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium">Current Plan</label>
                    <input type="text" name="current_plan" value="{{ old('current_plan', $user->current_plan) }}"
                        class="form-input w-full">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="form-select w-full">
                        <option value="active" @selected(old('status', $user->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $user->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">User Type</label>
                    <select name="user_type" class="form-select w-full">
                        <option value="user" @selected(old('user_type', $user->user_type) === 'user')>User</option>
                        <option value="admin" @selected(old('user_type', $user->user_type) === 'admin')>Admin</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1 rounded bg-blue-600 text-white">Save</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1 rounded bg-gray-200">Cancel</a>
            </div>
        </form>
    </div>
@endsection
