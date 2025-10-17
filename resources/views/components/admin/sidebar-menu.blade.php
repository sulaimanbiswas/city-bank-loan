<div class="sidebar-wrapper group">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">
        <x-admin.application-logo />
        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>
    <div id="nav_shadow"
        class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0">
    </div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
        id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title uppercase">MENU</li>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="navItem {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>Home</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="navItem {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:users"></iconify-icon>
                        <span>Users</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.plans.index') }}"
                    class="navItem {{ request()->routeIs('admin.plans.index') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="covid:covid-carrier-packages"></iconify-icon>
                        <span>Plans</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.loans.index') }}"
                    class="navItem {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="mdi:bank"></iconify-icon>
                        <span>Loans</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:cog-6-tooth"></iconify-icon>
                        <span>Settings</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.site-settings.index') }}"
                            class="{{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}">Site Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.limit.edit') }}"
                            class="{{ request()->routeIs('admin.limit.*') ? 'active' : '' }}">Limits</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gateways.index') }}"
                            class="{{ request()->routeIs('admin.gateways.*') ? 'active' : '' }}">Gateways</a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</div>
