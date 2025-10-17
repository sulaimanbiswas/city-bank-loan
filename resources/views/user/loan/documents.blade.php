<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ডকুমেন্ট আপলোড</h2>
    </x-slot>
    <div class="max-w-3xl mx-auto space-y-6">
        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('user.loan.documents.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">ডকুমেন্ট টাইপ</label>
                    <select name="doc_type" id="doc_type" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="nid">NID</option>
                        <option value="passport">Passport</option>
                        <option value="driving_licence">Driving Licence</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Front Side</label>
                        <input id="doc_front" type="file" name="doc_front" accept="image/*,application/pdf"
                            class="sr-only" required>
                        <div id="doc_front_zone"
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
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG, PDF up to 5MB</p>
                                <p id="doc_front_filename" class="text-sm text-gray-700 font-medium hidden"></p>
                            </div>
                        </div>
                        <div id="doc_front_preview" class="hidden h-48 overflow-hidden rounded-md"></div>
                        <button id="doc_front_remove" type="button"
                            class="mt-2 hidden items-center px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">Remove</button>
                    </div>
                    <div id="back_field">
                        <label class="block text-sm font-medium text-gray-700">Back Side</label>
                        <input id="doc_back" type="file" name="doc_back" accept="image/*,application/pdf"
                            class="sr-only">
                        <div id="doc_back_zone"
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
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG, PDF up to 5MB</p>
                                <p id="doc_back_filename" class="text-sm text-gray-700 font-medium hidden"></p>
                            </div>
                        </div>
                        <div id="doc_back_preview" class="hidden h-48 overflow-hidden rounded-md"></div>
                        <button id="doc_back_remove" type="button"
                            class="mt-2 hidden items-center px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">Remove</button>
                        <p class="text-xs text-gray-500 mt-1">NID requires front & back. Passport/Driving licence
                            typically requires only front.</p>
                    </div>
                </div>
                <div class="pt-2">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-[#ff0000] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#ff0000]/90">পরবর্তী</button>
                </div>
            </form>
        </div>


    </div>

    <script>
        const typeEl = document.getElementById('doc_type');
        const backField = document.getElementById('back_field');
        const frontInput = document.getElementById('doc_front');
        const backInput = document.getElementById('doc_back');
        const frontPreview = document.getElementById('doc_front_preview');
        const backPreview = document.getElementById('doc_back_preview');
        const frontRemove = document.getElementById('doc_front_remove');
        const backRemove = document.getElementById('doc_back_remove');
        const frontZone = document.getElementById('doc_front_zone');
        const backZone = document.getElementById('doc_back_zone');
        const frontName = document.getElementById('doc_front_filename');
        const backName = document.getElementById('doc_back_filename');

        function clearPreview(container) {
            if (!container) return;
            container.innerHTML = '';
            container.classList.add('hidden');
            // Show corresponding dropzone back when clearing
            if (container === frontPreview && frontZone) frontZone.classList.remove('hidden');
            if (container === backPreview && backZone) backZone.classList.remove('hidden');
            if (container === frontPreview && frontRemove) {
                frontRemove.classList.add('hidden');
                frontRemove.classList.remove('inline-flex');
            }
            if (container === backPreview && backRemove) {
                backRemove.classList.add('hidden');
                backRemove.classList.remove('inline-flex');
            }
            container.classList.remove('flex');
        }

        function renderPreview(container, file) {
            if (!container || !file) return clearPreview(container);
            const url = URL.createObjectURL(file);
            container.innerHTML = '';

            if (file.type && file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = url;
                img.alt = file.name;
                img.className = 'w-full h-full object-contain';
                img.onload = () => URL.revokeObjectURL(url);
                container.appendChild(img);
            } else if ((file.type && file.type === 'application/pdf') || /\.pdf$/i.test(file.name)) {
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.className = 'w-full h-full';
                iframe.title = file.name;
                container.appendChild(iframe);
                // Revoke later to keep preview working for PDF
                setTimeout(() => URL.revokeObjectURL(url), 5000);
            } else {
                const info = document.createElement('div');
                info.className = 'text-sm text-gray-600';
                info.textContent = `Selected: ${file.name}`;
                container.appendChild(info);
                setTimeout(() => URL.revokeObjectURL(url), 1000);
            }
            container.classList.remove('hidden');
            container.classList.add('flex');
            // Hide corresponding dropzone when preview is visible so it swaps in-place
            if (container === frontPreview && frontZone) frontZone.classList.add('hidden');
            if (container === backPreview && backZone) backZone.classList.add('hidden');
            if (container === frontPreview && frontRemove) {
                frontRemove.classList.remove('hidden');
                frontRemove.classList.add('inline-flex');
                if (frontName) {
                    frontName.textContent = file.name;
                    frontName.classList.remove('hidden');
                }
            }
            if (container === backPreview && backRemove) {
                backRemove.classList.remove('hidden');
                backRemove.classList.add('inline-flex');
                if (backName) {
                    backName.textContent = file.name;
                    backName.classList.remove('hidden');
                }
            }
        }

        function toggleBack() {
            const v = typeEl.value;
            const showBack = (v === 'nid');
            backField.style.display = showBack ? 'block' : 'none';
            if (!showBack) {
                if (backInput) backInput.value = '';
                clearPreview(backPreview);
            }
        }

        typeEl?.addEventListener('change', toggleBack);
        frontInput?.addEventListener('change', () => {
            const file = frontInput.files && frontInput.files[0];
            renderPreview(frontPreview, file);
        });
        backInput?.addEventListener('change', () => {
            const file = backInput.files && backInput.files[0];
            renderPreview(backPreview, file);
        });

        function setupDrop(zone, input, preview, nameLabel) {
            if (!zone || !input) return;
            // Click to open file dialog
            zone.addEventListener('click', () => input.click());

            // Drag & drop handlers
            ;
            ['dragenter', 'dragover'].forEach(evt => zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('bg-gray-50');
            }));;
            ['dragleave', 'drop'].forEach(evt => zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('bg-gray-50');
            }));
            zone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (!dt || !dt.files || dt.files.length === 0) return;
                input.files = dt.files; // Assign files
                const file = input.files[0];
                renderPreview(preview, file);
                if (nameLabel) {
                    nameLabel.textContent = file.name;
                    nameLabel.classList.remove('hidden');
                }
            });
        }

        setupDrop(frontZone, frontInput, frontPreview, frontName);
        setupDrop(backZone, backInput, backPreview, backName);

        frontRemove?.addEventListener('click', () => {
            if (frontInput) frontInput.value = '';
            clearPreview(frontPreview);
            if (frontName) {
                frontName.textContent = '';
                frontName.classList.add('hidden');
            }
        });
        backRemove?.addEventListener('click', () => {
            if (backInput) backInput.value = '';
            clearPreview(backPreview);
            if (backName) {
                backName.textContent = '';
                backName.classList.add('hidden');
            }
        });

        // Initialize on load
        toggleBack();
    </script>
</x-app-layout>
