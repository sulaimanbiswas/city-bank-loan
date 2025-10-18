<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">আমার প্রোফাইল</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('status') }}</div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white shadow rounded p-6">
            <div class="flex items-start gap-6">
                <div
                    class="h-20 w-20 rounded-full bg-[#ff0000]/10 flex items-center justify-center text-[#ff0000] text-2xl font-semibold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <div class="text-xl font-semibold">{{ $user->name }}</div>
                            <div class="text-sm text-slate-600">{{ $user->email }}</div>
                            <div class="text-sm text-slate-600">{{ $user->phone ?? 'Phone not set' }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">{{ ucfirst($user->status ?? 'active') }}</span>
                            <span
                                class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700">{{ ucfirst($user->user_type ?? 'user') }}</span>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="bg-gray-50 rounded p-3">
                            <div class="text-xs text-slate-500">ব্যালেন্স</div>
                            <div class="text-base font-semibold">৳{{ number_format($user->balance ?? 0, 2) }}</div>
                        </div>
                        <div class="bg-gray-50 rounded p-3">
                            <div class="text-xs text-slate-500">মোট লোন</div>
                            <div class="text-base font-semibold">{{ $totalLoans }}</div>
                        </div>
                        <div class="bg-gray-50 rounded p-3">
                            <div class="text-xs text-slate-500">অ্যাপ্রুভড</div>
                            <div class="text-base font-semibold">{{ $approvedLoans }}</div>
                        </div>
                        <div class="bg-gray-50 rounded p-3">
                            <div class="text-xs text-slate-500">পেন্ডিং</div>
                            <div class="text-base font-semibold">{{ $pendingLoans }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-base font-semibold text-[#ff0000] mb-4">কুইক অ্যাকশন</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('user.loan.apply') }}" class="group">
                    <div class="bg-gray-50 rounded p-4 text-center hover:bg-gray-100">
                        <i class="bx bx-shield-plus text-3xl text-[#ff0000]"></i>
                        <div class="mt-2 text-sm font-medium">নতুন লোন</div>
                    </div>
                </a>
                <a href="{{ route('user.loans.index') }}" class="group">
                    <div class="bg-gray-50 rounded p-4 text-center hover:bg-gray-100">
                        <i class="bx bxs-bank text-3xl text-[#ff0000]"></i>
                        <div class="mt-2 text-sm font-medium">আমার লোন</div>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}" class="group">
                    <div class="bg-gray-50 rounded p-4 text-center hover:bg-gray-100">
                        <i class="bx bx-user-circle text-3xl text-[#ff0000]"></i>
                        <div class="mt-2 text-sm font-medium">প্রোফাইল আপডেট</div>
                    </div>
                </a>
                <a href="#" class="group">
                    <div class="bg-gray-50 rounded p-4 text-center hover:bg-gray-100">
                        <i class="bx bx-list-ul text-3xl text-[#ff0000]"></i>
                        <div class="mt-2 text-sm font-medium">লেনদেন</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- About & Contact -->
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-base font-semibold text-[#ff0000] mb-4">অন্যান্য তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-slate-600">ঠিকানা</div>
                    <div class="text-sm">{{ $user->address ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-sm text-slate-600">যোগাযোগ</div>
                    <div class="text-sm">{{ $user->phone ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
