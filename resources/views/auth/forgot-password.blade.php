<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-gray-200 px-4 py-6 rounded my-4">
            <div class="text-center mb-4">
                <i class="bx bx-lock-open text-5xl text-[#ff0000]"></i>
                <h2 class="mt-2 text-2xl font-semibold text-gray-800">পাসওয়ার্ড রিসেট</h2>
                <p class="text-sm text-gray-600">নিচে ইমেইল দিন, আমরা রিসেট লিংক পাঠাব</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="bg-white rounded shadow p-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="ইমেইল" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="bg-[#ff0000] hover:bg-red-700 focus:bg-red-700 active:bg-red-800 border-0">
                        রিসেট লিংক পাঠান
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>