<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-gray-200 px-4 py-6 rounded my-4">
            <div class="text-center mb-4">
                <i class="bx bx-check-shield text-5xl text-[#ff0000]"></i>
                <h2 class="mt-2 text-2xl font-semibold text-gray-800">পাসওয়ার্ড নিশ্চিত করুন</h2>
                <p class="text-sm text-gray-600">নিরাপত্তার জন্য আপনার পাসওয়ার্ড প্রবেশ করুন</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="bg-white rounded shadow p-4">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="পাসওয়ার্ড" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <x-primary-button class="bg-[#ff0000] hover:bg-red-700 focus:bg-red-700 active:bg-red-800 border-0">
                        কনফার্ম
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>