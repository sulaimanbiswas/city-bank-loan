@extends('layouts.admin')

@section('title', 'Edit Site Setting')

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
            <li class="inline-block relative text-sm text-slate-500 font-Inter">Edit Site Setting</li>
        </ul>
    </div>

    <div class="card">
        <header class="card-header noborder">
            <h4 class="card-title">Edit Setting</h4>
        </header>
        <div class="card-body px-6 pb-6">
            <form action="{{ route('admin.site-settings.update', $setting) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Site Link</label>
                        <input type="url" name="site_link" value="{{ old('site_link', $setting->site_link) }}"
                            class="form-control" />
                        @error('site_link')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Site Title</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $setting->site_title) }}"
                            class="form-control" />
                        @error('site_title')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Keywords</label>
                        <input type="text" name="keywords" value="{{ old('keywords', $setting->keywords) }}"
                            class="form-control" />
                        @error('keywords')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Site Name</label>
                        <input type="url" name="my_site" value="{{ old('site_name', $setting->my_site) }}"
                            class="form-control" />
                        @error('my_site')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tiktok</label>
                        <input type="url" name="tiktok" value="{{ old('tiktok', $setting->tiktok) }}"
                            class="form-control" />
                        @error('tiktok')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Whatsapp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}"
                            class="form-control" placeholder="e.g., +8801XXXXXXXXX or wa.me link" />
                        @error('whatsapp')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Youtube</label>
                        <input type="url" name="youtube" value="{{ old('youtube', $setting->youtube) }}"
                            class="form-control" />
                        @error('youtube')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Telegram</label>
                        <input type="url" name="telegram" value="{{ old('telegram', $setting->telegram) }}"
                            class="form-control" />
                        @error('telegram')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $setting->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button class="btn btn-primary">Save changes</button>
                    <a href="{{ route('admin.site-settings.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
