<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">লোন আবেদন</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('user.loan.apply.preview') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">ব্যবহারকারীর নাম</label>
                    <input type="text" class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100"
                        value="{{ $user->name }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">লোনের পরিমাণ</label>
                    <select name="amount_value" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="">একটি নির্বাচন করুন</option>
                        @foreach ($amountOptions as $opt)
                            <option value="{{ $opt->value }}" @selected(old('amount_value') == $opt->value)>{{ $opt->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">মেয়াদ</label>
                    <select name="duration_value" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="">একটি নির্বাচন করুন</option>
                        @foreach ($durationOptions as $opt)
                            <option value="{{ $opt->value }}" @selected(old('duration_value') == $opt->value)>{{ $opt->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">লোনের কারণ</label>
                    <select name="reason_value" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="">একটি নির্বাচন করুন</option>
                        @foreach ($reasonOptions as $opt)
                            <option value="{{ $opt->value }}" @selected(old('reason_value') == $opt->value)>{{ $opt->label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-[#ff0000] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#ff0000]/90">
                        আবেদন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
