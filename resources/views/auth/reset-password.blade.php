<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-gray-200 px-4 py-6 rounded my-4">
            <div class="text-center mb-4">
                <i class="bx bx-lock text-5xl text-[#ff0000]"></i>
                <h2 class="mt-2 text-2xl font-semibold text-gray-800">নতুন পাসওয়ার্ড সেট করুন</h2>
                <p class="text-sm text-gray-600">নিচে তথ্য পূরণ করে পাসওয়ার্ড পরিবর্তন করুন</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="bg-white rounded shadow p-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="ইমেইল" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" value="নতুন পাসওয়ার্ড" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" value="পাসওয়ার্ড নিশ্চিত করুন" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="bg-[#ff0000] hover:bg-red-700 focus:bg-red-700 active:bg-red-800 border-0">
                        পাসওয়ার্ড রিসেট
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>