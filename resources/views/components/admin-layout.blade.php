@props(['title' => 'Admin Panel', 'showNav' => null])

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <script>
        (function () {
            try {
                var storedTheme = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var useDark = storedTheme ? storedTheme === 'dark' : prefersDark;
                document.documentElement.classList.toggle('dark', useDark);
            } catch (error) {
                document.documentElement.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches);
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
    </script>
    <link rel="icon" href="{{ asset('mouse.jpeg') }}">
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 transition-colors duration-300 dark:bg-slate-950 dark:text-gray-100">
    @php
        $showNav = $showNav ?? auth('admin')->check();
        $navItems = [
            ['label' => 'Overview', 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
            ['label' => 'Orders', 'route' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.*')],
            ['label' => 'Products', 'route' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*')],
            ['label' => 'Users', 'route' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*') || request()->routeIs('admin.order-items.*')],
            ['label' => 'Messages', 'route' => route('admin.messages.index'), 'active' => request()->routeIs('admin.messages.*')],
            ['label' => 'Returns', 'route' => route('admin.returns.index'), 'active' => request()->routeIs('admin.returns.*')],
        ];
    @endphp

    <nav class="sticky top-0 z-50 bg-white text-gray-900 shadow-lg transition-colors duration-300 dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-3">
            <div class="flex items-center gap-8">
                <a href="{{ $showNav ? route('admin.dashboard') : route('admin.login') }}" class="shrink-0">
                    <img id="admin-logo" src="{{ asset('images/logo-removebg-preview.png') }}" alt="Happy Hardware" class="h-10 w-auto drop-shadow-lg md:h-12">
                </a>

                @if ($showNav)
                    <div id="admin-nav-links" class="relative hidden items-center space-x-1 rounded-full bg-gray-100 px-2 py-1 md:flex dark:bg-white/5">
                        <span id="admin-nav-active-pill" class="pointer-events-none absolute inset-y-1 left-0 rounded-full bg-gray-200 transition-all duration-300 ease-out dark:bg-white/10"></span>
                        @foreach ($navItems as $item)
                            <a href="{{ $item['route'] }}" data-nav-link data-active="{{ $item['active'] ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ $item['active'] ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="hidden rounded-full border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-gray-100 hover:text-gray-900 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-white md:inline-flex">
                    Store Home
                </a>

                <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="rounded-full border border-gray-300 p-2 text-gray-700 transition-all duration-200 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden size-6 dark:block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6 dark:hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                @if ($showNav)
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-full bg-gray-900 px-5 py-2 text-sm font-semibold text-white transition-all duration-300 hover:bg-gray-700 dark:bg-white dark:text-gray-900">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </nav>

    <main class="pb-12">
        {{ $slot }}
    </main>

    <script>
        (function () {
            var root = document.documentElement;
            window.toggleTheme = function () {
                var willBeDark = !root.classList.contains('dark');
                root.classList.toggle('dark', willBeDark);
                try {
                    localStorage.setItem('theme', willBeDark ? 'dark' : 'light');
                } catch (error) {
                }
            };

            var navContainer = document.getElementById('admin-nav-links');
            var indicator = document.getElementById('admin-nav-active-pill');
            if (navContainer && indicator) {
                var hideIndicator = function () {
                    indicator.style.width = '0px';
                    indicator.style.transform = 'translateX(0px)';
                };

                var moveIndicator = function (targetLink) {
                    if (!targetLink) {
                        hideIndicator();
                        return;
                    }

                    indicator.style.width = targetLink.offsetWidth + 'px';
                    indicator.style.transform = 'translateX(' + targetLink.offsetLeft + 'px)';
                };

                requestAnimationFrame(function () {
                    moveIndicator(navContainer.querySelector('[data-active="true"]'));
                });

                window.addEventListener('resize', function () {
                    moveIndicator(navContainer.querySelector('[data-active="true"]'));
                });
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
