<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="bg-gray-200 px-4 py-6 rounded my-4">
            <div class="text-center mb-4">
                <i class="bx bx-envelope text-5xl text-[#ff0000]"></i>
                <h2 class="mt-2 text-2xl font-semibold text-gray-800">ইমেইল যাচাই করুন</h2>
                <p class="text-sm text-gray-600">রেজিস্ট্রেশনের সময় দেওয়া ইমেইলে ভেরিফিকেশন লিংক পাঠানো হয়েছে</p>
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
            @endif

            <div class="mt-4 flex items-center justify-between bg-white rounded shadow p-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <x-primary-button class="bg-[#ff0000] hover:bg-red-700 focus:bg-red-700 active:bg-red-800 border-0">
                        ভেরিফিকেশন ইমেইল আবার পাঠান
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                        লগআউট
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>