@extends('layouts.admin')

@section('title', 'Site Settings')

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
            <li class="inline-block relative text-sm text-primary-500 font-Inter ">
                Settings
                <iconify-icon icon="heroicons-outline:chevron-right"
                    class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Site Settings</li>
        </ul>
    </div>

    <div class="space-y-5">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card">
            <header class="card-header noborder flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <h4 class="card-title">Site Settings</h4>
                <div class="shrink-0">
                    <a href="{{ route('admin.site-settings.edit', $setting) }}" class="btn btn-primary">Edit
                        Settings</a>
                </div>
            </header>
            <div class="card-body px-6 pb-6">
                @if ($setting)

                    <!-- Details grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- General info -->
                        <div
                            class="p-4 rounded border bg-white lg:col-span-2 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-xs text-slate-500 mb-1">Site Title</div>
                                    <div class="font-medium">{{ $setting->site_title ?: '—' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500 mb-1">Site Name</div>
                                    <div class="font-medium">{{ $setting->site_name ?: '—' }}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-xs text-slate-500 mb-1">Keywords</div>
                                    @php
                                        $keywords = collect(explode(',', (string) $setting->keywords))
                                            ->map(function ($s) {
                                                return trim($s);
                                            })
                                            ->filter();
                                    @endphp
                                    @if ($keywords->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($keywords as $kw)
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-xs bg-slate-100 dark:bg-slate-700 border">{{ $kw }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-slate-400">—</div>
                                    @endif
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-xs text-slate-500 mb-1">Description</div>
                                    <div class="text-slate-700 dark:text-slate-400">{{ $setting->description ?: '—' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Social / contact -->
                        <div
                            class="p-4 rounded border bg-white dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700">
                            <div class="text-xs text-slate-500 mb-2">Social & Contact</div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="mdi:web" class="text-lg"></iconify-icon>
                                        <span>Site Link</span>
                                    </div>
                                    @if ($setting->site_link)
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="btn btn-outline px-2 py-1 text-xs copy-btn"
                                                data-copy="{{ $setting->site_link }}">Copy</button>

                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="famicons:logo-tiktok" class="text-lg"></iconify-icon>
                                        <span>Tiktok</span>
                                    </div>
                                    @if ($setting->tiktok)
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="btn btn-outline px-2 py-1 text-xs copy-btn"
                                                data-copy="{{ $setting->tiktok }}">Copy</button>

                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="mdi:youtube" class="text-lg"></iconify-icon>
                                        <span>Youtube</span>
                                    </div>
                                    @if ($setting->youtube)
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="btn btn-outline px-2 py-1 text-xs copy-btn"
                                                data-copy="{{ $setting->youtube }}">Copy</button>

                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="mdi:whatsapp" class="text-lg"></iconify-icon>
                                        <span>Whatsapp</span>
                                    </div>
                                    @if ($setting->whatsapp)
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="btn btn-outline px-2 py-1 text-xs copy-btn"
                                                data-copy="{{ $setting->whatsapp }}">Copy</button>
                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="mdi:telegram" class="text-lg"></iconify-icon>
                                        <span>Telegram</span>
                                    </div>
                                    @if ($setting->telegram)
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="btn btn-outline px-2 py-1 text-xs copy-btn"
                                                data-copy="{{ $setting->telegram }}">Copy</button>
                                        </div>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-600 mb-4">No settings found.</p>
                        <a href="{{ route('admin.site-settings.create') }}" class="btn btn-primary">Create New</a>
                    </div>
                @endif
            @endsection

            @push('scripts')
                <script>
                    document.addEventListener('click', function(e) {
                        var btn = e.target.closest('.copy-btn');
                        if (!btn) return;
                        var val = btn.getAttribute('data-copy') || '';
                        if (!val) return;
                        navigator.clipboard.writeText(val).then(function() {
                            btn.textContent = 'Copied';
                            setTimeout(function() {
                                btn.textContent = 'Copy';
                            }, 1200);
                        }).catch(function() {
                            // fallback
                            var ta = document.createElement('textarea');
                            ta.value = val;
                            document.body.appendChild(ta);
                            ta.select();
                            try {
                                document.execCommand('copy');
                                btn.textContent = 'Copied';
                                setTimeout(function() {
                                    btn.textContent = 'Copy';
                                }, 1200);
                            } catch (err) {}
                            document.body.removeChild(ta);
                        });
                    });
                </script>
            @endpush
