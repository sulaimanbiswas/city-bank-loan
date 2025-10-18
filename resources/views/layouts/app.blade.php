<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @if (session('impersonator_id'))
        <div class="container mx-auto max-w-5xl w-full bg-[#ff0000] text-white text-sm py-2 mb-2">
            <div class=" flex items-center justify-between px-5">
                <span>You are browsing as a user.</span>
                <form method="POST" action="{{ route('impersonate.stop') }}">
                    @csrf
                    <button class="px-2 py-1 bg-white text-[#ff0000] rounded">Return to Admin</button>
                </form>
            </div>
        </div>
    @endif
    <!-- Preloader -->
    <div id="app-preloader"
        class="fixed inset-0 z-[9999] bg-white grid place-items-center transition-opacity duration-300">
        <div class="flex flex-col items-center gap-3">
            <img src="{{ asset('images/main_logo.jpg') }}" alt="Logo" class="h-12 w-auto">
            <div class="h-8 w-8 border-4 border-[#ff0000] border-t-transparent rounded-full animate-spin"></div>
            <p class="text-sm text-gray-600">লোড হচ্ছে...</p>
        </div>
    </div>
    <div class="container mx-auto max-w-5xl border border-red-600 px-2 my-1">
        <header class="mb-2 relative overflow-hidden rounded">
            <img src="{{ asset('images/topimg.jpg') }}" alt=""
                class="absolute inset-0 w-full h-full object-cover">
            <div class="relative flex-col  flex  justify-between p-2 bg-white/70 backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <a href="{{ route('user.dashboard') }}">
                            <img src="{{ asset('images/main_logo.jpg') }}" alt="Main Logo" class="h-12 w-auto" />
                        </a>
                    </div>
                    @auth
                        <nav class="flex items-center gap-2">
                            <a href="{{ route('profile.edit') }}"
                                class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs bg-white/90 hover:bg-white border border-gray-200 shadow">
                                <i class='bx bx-user-circle text-base'></i>
                                প্রোফাইল
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs bg-white/90 hover:bg-white border border-gray-200 shadow text-red-600">
                                    <i class='bx bx-log-out text-base'></i>
                                    লগআউট
                                </button>
                            </form>
                        </nav>
                    @endauth
                </div>
                <div class="flex items-center gap-3 mt-3 bg-[#ff0000] px-2 py-1 rounded-xs">
                    <span class="text-white font-semibold text-sm uppercase">স্বাগতম, {{ Auth::user()->name }}!</span>

                </div>
            </div>
        </header>
        <div class="bg-gray-200 px-2 py-1 rounded-xs mt-2">
            <marquee class="text-black font-medium text-sm" behavior="scroll" direction="left" onmouseover="this.stop()"
                onmouseout="this.start()">আপনার আর্থিক সহায়তার জন্য আমরা প্রস্তুত</marquee>
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <footer class="text-center text-white bg-[#ff0000] text-xs py-2">
            <span class="font-semibold">© 2025 City Bank PLC. All rights reserved.</span>
        </footer>
    </div>
    <script>
        window.addEventListener('load', function() {
            var el = document.getElementById('app-preloader');
            if (el) {
                el.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(function() {
                    el.style.display = 'none';
                }, 300);
            }
        });
    </script>
</body>

</html>
