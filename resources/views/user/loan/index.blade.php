<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">আমার লোন</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-6">
            @if ($loans->isEmpty())
                <div class="text-gray-500">আপনার কোনো লোন নেই।</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($loans as $loan)
                        @php
                            $base = \Carbon\Carbon::parse($loan->processed_at ?? $loan->created_at)->startOfDay();
                            $today = now()->startOfDay();
                            $nextEmi = null;
                            if ($loan->status === 'approved' && $loan->duration_months && $loan->monthly_installment) {
                                $monthsElapsed = $base->diffInMonths($today);
                                $k = min($monthsElapsed + 1, (int) $loan->duration_months);
                                if ($k <= (int) $loan->duration_months) {
                                    $nextEmi = $base->copy()->addMonths($k);
                                }
                            }
                            $badgeClass = match ($loan->status) {
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp
                        <div class="border rounded p-4 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-600">#{{ $loan->id }}</div>
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full {{ $badgeClass }}">{{ ucfirst($loan->status) }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 rounded p-3">
                                    <div class="text-xs text-slate-500">মোট লোন</div>
                                    <div class="text-base font-semibold">৳{{ number_format($loan->principal ?? 0, 2) }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded p-3">
                                    <div class="text-xs text-slate-500">EMI</div>
                                    <div class="text-base font-semibold">
                                        ৳{{ number_format($loan->monthly_installment ?? 0, 2) }}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 px-3">
                                <div>
                                    <div class="text-xs text-slate-500">মেয়াদ</div>
                                    <div class="text-sm">{{ $loan->duration_months ?? '-' }} মাস</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">আবেদনের তারিখ</div>
                                    <div class="text-sm">{{ optional($loan->created_at)->format('M d, Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Next EMI Date</div>
                                    <div class="text-sm">{{ $nextEmi ? $nextEmi->format('M d, Y') : '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">মোট পরিশোধযোগ্য</div>
                                    <div class="text-sm">৳{{ number_format($loan->total_payable ?? 0, 2) }}</div>
                                </div>
                            </div>
                            @if ($loan->status === 'rejected' && $loan->admin_note)
                                <div class="mt-2 text-sm">
                                    <span class="font-medium text-red-600">রিজেক্ট নোট:</span>
                                    <span class="text-slate-700">{{ $loan->admin_note }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
