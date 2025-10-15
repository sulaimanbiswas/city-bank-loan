<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto">
        <div class="bg-gray-200 px-4 py-6 rounded my-4">
            <div class="text-center mb-4">
                <i class="bx bx-user-circle text-5xl text-[#ff0000]"></i>
                <h2 class="mt-2 text-2xl font-semibold text-gray-800">লগইন</h2>
                <p class="text-sm text-gray-600">আপনার একাউন্টে প্রবেশ করুন</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="bg-white rounded shadow p-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="ইমেইল" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" value="পাসওয়ার্ড" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-[#ff0000] shadow-sm focus:ring-[#ff0000]"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">মনে রাখুন</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            পাসওয়ার্ড ভুলে গেছেন?
                        </a>
                    @endif

                    <x-primary-button
                        class="ms-3 bg-[#ff0000] hover:bg-red-700 focus:bg-red-700 active:bg-red-800 border-0">
                        লগইন
                    </x-primary-button>
                </div>

                <div class="mt-4 text-center text-sm text-gray-600">
                    একাউন্ট নেই?
                    <a href="{{ route('register') }}" class="font-medium text-[#ff0000] hover:underline">রেজিস্ট্রেশন
                        করুন</a>
                </div>
            </form>
        </div>
        <div class="text-center">
            <button id="userLoginBtn"
                class="bg-blue-500 text-white text-xs px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 me-2">
                ইউজার হিসেবে লগইন
            </button>
            <button id="adminLoginBtn"
                class="bg-green-500 text-white text-xs px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                অ্যাডমিন হিসেবে লগইন
            </button>
        </div>

        <script>
            document.getElementById('userLoginBtn').addEventListener('click', function() {
                document.getElementById('email').value = 'test@example.com';
                document.getElementById('password').value = 'password';
            });
            document.getElementById('adminLoginBtn').addEventListener('click', function() {
                document.getElementById('email').value = 'admin@example.com';
                document.getElementById('password').value = 'password';
            });
        </script>
    </div>
</x-guest-layout>
