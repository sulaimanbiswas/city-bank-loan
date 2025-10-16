@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Users</h1>
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name/email/phone"
                    class="form-input" />
                <button class="btn btn-primary px-3 py-1 bg-slate-800 text-white rounded">Search</button>
            </form>
        </div>

        @if (session('status'))
            <div class="p-2 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 pr-2">#</th>
                        <th class="py-2 pr-2">Name</th>
                        <th class="py-2 pr-2">Email</th>
                        <th class="py-2 pr-2">Phone</th>
                        <th class="py-2 pr-2">Balance</th>
                        <th class="py-2 pr-2">Plan</th>
                        <th class="py-2 pr-2">Status</th>
                        <th class="py-2 pr-2">Type</th>
                        <th class="py-2 pr-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b">
                            <td class="py-2 pr-2">{{ $user->id }}</td>
                            <td class="py-2 pr-2">{{ $user->name }}</td>
                            <td class="py-2 pr-2">{{ $user->email }}</td>
                            <td class="py-2 pr-2">{{ $user->phone ?? '-' }}</td>
                            <td class="py-2 pr-2">{{ number_format($user->balance ?? 0, 2) }}</td>
                            <td class="py-2 pr-2">{{ $user->current_plan ?? '-' }}</td>
                            <td class="py-2 pr-2">
                                <span
                                    class="px-2 py-0.5 rounded text-xs {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="py-2 pr-2">{{ ucfirst($user->user_type) }}</td>
                            <td class="py-2 pr-0">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="px-2 py-1 rounded bg-blue-600 text-white">Edit</a>
                                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                        @csrf
                                        <button
                                            class="px-2 py-1 rounded bg-amber-500 text-white">{{ $user->status === 'active' ? 'Inactive' : 'Activate' }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                        onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 rounded bg-red-600 text-white">Delete</button>
                                    </form>
                                    @if (auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.impersonate', $user) }}">
                                            @csrf
                                            <button class="px-2 py-1 rounded bg-slate-800 text-white">Login as</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-3 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
