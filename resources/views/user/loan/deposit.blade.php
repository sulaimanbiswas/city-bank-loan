<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">জামানত জমা</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('status') }}</div>
        @endif

        <div class="bg-white shadow rounded p-6 space-y-6">
            <div class="flex items-center justify-between rounded border bg-gray-50 px-4 py-3">
                <div class="text-sm text-slate-600">প্রয়োজনীয় জামানত (10%)</div>
                <div class="text-base font-semibold">৳{{ number_format($depositRequired ?? 0, 2) }}</div>
            </div>

            <form method="POST" action="{{ route('user.loan.deposit.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">গেটওয়ে নির্বাচন করুন <span
                            class="text-red-500">*</span></label>
                    <select name="gateway_id" id="gateway_id"
                        class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="">Select Gateway</option>
                        @foreach ($gateways as $g)
                            <option value="{{ $g->id }}" data-account="{{ $g->account_number }}"
                                data-logo="{{ $g->logo_url }}">{{ $g->method }}</option>
                        @endforeach
                    </select>
                    @error('gateway_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div id="gateway_preview" style="display:none;"
                    class="border rounded p-3 bg-gray-50 flex items-center gap-3">
                    <img id="gateway_logo" src="" alt="logo" class="h-9 w-9 object-contain rounded">
                    <div class="text-sm">
                        <div id="gateway_method" class="font-medium"></div>
                        <div class="mt-1">অ্যাকাউন্ট: <span id="gateway_account" class="font-mono"></span>
                            <button type="button" id="copy_account"
                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200">কপি</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ট্রান্সেকশন আইডি <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="transaction_id" placeholder="e.g., TXN123456"
                            class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('transaction_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">স্ক্রিনশট (ঐচ্ছিক)</label>
                        <input id="screenshot_input" type="file" name="screenshot" accept="image/*" class="sr-only">
                        <div id="screenshot_zone"
                            class="mt-1 flex justify-center items-center px-6 pt-5 pb-6 h-48 border-2 border-dashed rounded-md text-center hover:bg-gray-50 cursor-pointer">
                            <div class="space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="mx-auto h-10 w-10 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-3-6-6-6m0 0-6 6m6-6V15" />
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium text-indigo-600 hover:text-indigo-500">Click to
                                        upload</span>
                                    <span class="px-1">or drag and drop</span>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                                <p id="screenshot_filename" class="text-sm text-gray-700 font-medium hidden"></p>
                            </div>
                        </div>
                        <div id="screenshot_preview" class="hidden h-48 overflow-hidden rounded-md"></div>
                        <button id="screenshot_remove" type="button"
                            class="mt-2 hidden items-center px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">Remove</button>
                        @error('screenshot')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <button
                        class="inline-flex items-center px-5 py-2 bg-[#ff0000] border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-[#ff0000]/90">জমা
                        দিন</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const gatewaySelect = document.getElementById('gateway_id');
        const previewWrap = document.getElementById('gateway_preview');
        const logoImg = document.getElementById('gateway_logo');
        const accountSpan = document.getElementById('gateway_account');
        const copyBtn = document.getElementById('copy_account');
        const methodSpan = document.getElementById('gateway_method');
        gatewaySelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const account = option.getAttribute('data-account');
            const logo = option.getAttribute('data-logo');
            if (account) {
                if (methodSpan) methodSpan.textContent = option.text;
                accountSpan.textContent = account;
                logoImg.src = logo || '';
                previewWrap.style.display = 'flex';
            } else {
                previewWrap.style.display = 'none';
            }
        });
        copyBtn.addEventListener('click', function() {
            const text = accountSpan.textContent;
            navigator.clipboard.writeText(text);
            this.textContent = 'কপি হয়েছে';
            setTimeout(() => this.textContent = 'কপি', 1500);
        });

        // Screenshot dropzone/preview
        const ssInput = document.getElementById('screenshot_input');
        const ssZone = document.getElementById('screenshot_zone');
        const ssPreview = document.getElementById('screenshot_preview');
        const ssRemove = document.getElementById('screenshot_remove');
        const ssName = document.getElementById('screenshot_filename');

        function ssClear() {
            if (!ssInput) return;
            ssInput.value = '';
            ssPreview.innerHTML = '';
            ssPreview.classList.add('hidden');
            ssZone.classList.remove('hidden');
            ssRemove.classList.add('hidden');
            ssRemove.classList.remove('inline-flex');
            if (ssName) {
                ssName.textContent = '';
                ssName.classList.add('hidden');
            }
        }

        function ssRender(file) {
            if (!file) return ssClear();
            const url = URL.createObjectURL(file);
            ssPreview.innerHTML = '';
            const img = document.createElement('img');
            img.src = url;
            img.alt = file.name;
            img.className = 'w-full h-full object-contain';
            img.onload = () => URL.revokeObjectURL(url);
            ssPreview.appendChild(img);
            ssPreview.classList.remove('hidden');
            ssZone.classList.add('hidden');
            ssRemove.classList.remove('hidden');
            ssRemove.classList.add('inline-flex');
            if (ssName) {
                ssName.textContent = file.name;
                ssName.classList.remove('hidden');
            }
        }

        ssZone?.addEventListener('click', () => ssInput?.click());
        ssInput?.addEventListener('change', () => {
            const file = ssInput.files && ssInput.files[0];
            if (file && file.type && file.type.startsWith('image/')) {
                ssRender(file);
            } else {
                ssClear();
            }
        });;
        ['dragenter', 'dragover'].forEach(evt => ssZone?.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            ssZone.classList.add('bg-gray-50');
        }));;
        ['dragleave', 'drop'].forEach(evt => ssZone?.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            ssZone.classList.remove('bg-gray-50');
        }));
        ssZone?.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            if (!dt || !dt.files || dt.files.length === 0) return;
            ssInput.files = dt.files;
            const f = dt.files[0];
            if (f && f.type && f.type.startsWith('image/')) ssRender(f);
        });
        ssRemove?.addEventListener('click', ssClear);
    </script>
</x-app-layout>
