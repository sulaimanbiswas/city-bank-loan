<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="dark nav-floating">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Admin') }} — @yield('title', 'Dashboard')</title>

    <!-- BEGIN: Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- END: Google Font -->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}">
    <!-- END: Theme CSS-->
    @stack('styles')
    @vite(['resources/css/app.css'])

    <script src="{{ asset('admin/assets/js/settings.js') }}" sync></script>
</head>

<body class="font-inter dashcode-app" id="body_class">
    <!-- Preloader -->
    {{-- <div id="app-preloader" class="fixed inset-0 bg-white transition-opacity duration-300"
        style="z-index: 9999; display:flex; align-items:center; justify-content:center;">
        <div class="flex flex-col items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            <div class="h-8 w-8 border-4 border-[#ff0000] border-t-transparent rounded-full animate-spin"></div>
            <p class="text-sm text-gray-600">লোড হচ্ছে...</p>
        </div>
    </div> --}}
    <div class="app-wrapper h-screen">
        <x-admin.sidebar-menu />
        <div class="app-content flex-1 ">
            <!-- BEGIN: header -->
            <x-admin.dashboard-header />
            <!-- BEGIN: header -->
            <div class="content-wrapper  transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]"
                id="content_wrapper">
                <div class="page-content">
                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <main id="content_layout">
                            <!-- Page Content -->
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        </div>
        {{-- <x-admin.dashboard-footer /> --}}
    </div>
    <!-- Core Js -->
    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/js/tw-elements-1.0.0-alpha13.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/SimpleBar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/iconify.js') }}"></script>
    <!-- Jquery Plugins -->

    <!-- app js -->
    <script src="{{ asset('admin/assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script>
        // Hide preloader when admin assets and page are loaded
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
    @stack('scripts')
</body>

</html>
