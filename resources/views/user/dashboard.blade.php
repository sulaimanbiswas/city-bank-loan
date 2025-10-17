<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-gray-200 px-2 py-4 rounded-xs my-2">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-shield-plus text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">লোন আবেদন</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-shield-minus text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">ক্যাশ আউট</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-wallet text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">জমা দিন</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-user-circle text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">প্রোফাইল</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bxs-bank text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">আমার লোন</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-list-ul text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">লেনদেনসমূহ</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bxl-whatsapp text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">যোগাযোগ</span>
                </div>
            </a>
            <a href="#" class="text-base font-medium">
                <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center hover:bg-gray-100">
                    <i class="bx bx-info-circle text-4xl text-[#ff0000] mb-2"></i>
                    <span class="text-base font-medium">সম্পর্কে</span>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
