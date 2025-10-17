<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">LOAN APPLICATION</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold text-[#ff0000] mb-4">অ্যামাউন্ট বিস্তারিত</h3>
            <div class="divide-y">
                <div class="py-2 flex justify-between">
                    <span>লোনের পরিমাণ:</span>
                    <span>৳{{ number_format($principal ?? 0, 2) }}</span>
                </div>
                <div class="py-2 flex justify-between">
                    <span>ইন্টারেস্ট রেট:</span>
                    <span>{{ number_format($interestRate ?? 0, 2) }}%</span>
                </div>
                <div class="py-2 flex justify-between">
                    <span>মোট ইন্টারেস্ট:</span>
                    <span>৳{{ number_format($interestAmount ?? 0, 2) }}</span>
                </div>
                <div class="py-2 flex justify-between">
                    <span>মোট পরিশোধযোগ্য:</span>
                    <span>৳{{ number_format($totalPayable ?? 0, 2) }}</span>
                </div>
                <div class="py-2 flex justify-between opacity-50">
                    <span>জামানত:</span>
                    <span>৳500.00</span>
                </div>
            </div>
            <div class="text-center mt-4">
                <form method="POST" action="{{ route('user.loan.apply.store') }}">
                    @csrf
                    <input type="hidden" name="amount_value" value="{{ $validated['amount_value'] }}">
                    <input type="hidden" name="duration_value" value="{{ $validated['duration_value'] }}">
                    <input type="hidden" name="reason_value" value="{{ $validated['reason_value'] }}">
                    <button class="px-4 py-2 bg-[#ff0000] text-white rounded hover:bg-[#ff0000]/90">এগিয়ে যান</button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold text-[#ff0000] mb-4">পরিশোধের সময়সূচি</h3>
            <div class="space-y-4">
                @forelse ($schedule as $item)
                    <div class="border rounded p-4 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600">{{ $item['date']->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-700">আসল: ৳{{ number_format($item['emi'], 2) }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-gray-900 font-medium">৳{{ number_format($item['emi'], 2) }}</div>
                            <div class="text-gray-500 text-sm">ইন্টারেস্ট: ৳{{ number_format($item['interest'], 2) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500">কোনো সময়সূচি পাওয়া যায়নি</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
