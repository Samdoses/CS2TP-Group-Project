@php
    $basketPreviewItems = auth()->check() && isset($globalBasketPreview) && $globalBasketPreview
        ? $globalBasketPreview->items->take(4)
        : collect();
    $showBasketPreview = auth()->check() && ! request()->routeIs('basket.view');
@endphp

<nav class="sticky top-0 z-50 bg-white text-gray-900 shadow-lg transition-colors duration-300 dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 sm:px-6">
            <div class="flex justify-between items-center gap-3">

                {{-- Logo & Nav Links --}}
                <div class="flex items-center gap-3 md:gap-8">
                    <a href="/" class="shrink-0">
                        <img id="main-logo" src="{{ asset('images/logo-removebg-preview.png') }}" alt="Happy Hardware" class="h-12 w-auto drop-shadow-lg sm:h-14 md:h-16" >
                    </a>

                    <div id="main-nav-links" class="relative hidden md:flex items-center rounded-full bg-gray-100 px-2 py-1 space-x-1 dark:bg-white/5">
                        <span id="main-nav-active-pill" class="pointer-events-none absolute inset-y-1 left-0 rounded-full bg-gray-200 transition-all duration-300 ease-out dark:bg-white/10"></span>
                        <a href="/" data-nav-link data-active="{{ request()->routeIs('home') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">Home</a>
                        <a href="/store" data-nav-link data-active="{{ request()->is('store*') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('store*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">Store</a>
                        <a href="/build-guide" data-nav-link data-active="{{ request()->is('build-guide*') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('build-guide*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">Build Guide</a>
                        <a href="{{ route('part-picker') }}" data-nav-link data-active="{{ request()->is('part-picker*') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('part-picker*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">Part Picker</a>
                        <a href="/about" data-nav-link data-active="{{ request()->is('about*') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('about*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">About</a>
                        <a href="/contact" data-nav-link data-active="{{ request()->is('contact*') ? 'true' : 'false' }}" class="relative z-10 rounded-full px-5 py-2 text-sm font-medium transition-colors duration-200 {{ request()->is('contact*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">Contact</a>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                    <button id="mobile-menu-toggle" type="button" class="md:hidden rounded-full border border-gray-300 p-2 text-gray-700 hover:bg-gray-100 transition-all duration-200 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-white/10 focus:outline-none" aria-label="Toggle navigation menu">
                        <svg id="mobile-menu-open-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg id="mobile-menu-close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="rounded-full border border-gray-300 p-2 flex items-center justify-center text-xs font-semibold text-gray-700 hover:bg-gray-100 transition-all duration-200 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-white/10 focus:outline-none">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden dark:block size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block dark:hidden size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>


                    </button>

                    @guest
                        <a href="/login" class="hidden sm:inline-flex rounded-full px-5 py-2 text-sm font-semibold bg-gray-900 text-white hover:bg-purple-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg dark:bg-white dark:text-gray-900">Sign In</a>
                        <a href="/register" class="hidden lg:inline-flex rounded-full px-5 py-2 text-sm font-medium border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all duration-300 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-white dark:hover:border-white/40">Register</a>
                    @endguest

                    @auth
                        <span class="hidden lg:inline text-sm font-medium text-gray-700 dark:text-gray-300">Welcome, {{ auth()->user()->first_name ?? 'User' }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="rounded-full px-5 py-2 text-sm font-medium border border-red-400/40 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-300 dark:border-red-500/30 dark:text-red-300">
                                Sign Out
                            </button>
                        </form>
                    @endauth

                    <div class="ml-1 sm:ml-2 flex items-center space-x-1 sm:space-x-2 border-l border-gray-300 pl-2 sm:pl-4 dark:border-white/10">
                        <a href="/profile" class="rounded-full p-2 hover:bg-gray-100 transition-all duration-200 dark:hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600 hover:text-gray-900 transition-colors duration-200 dark:text-gray-400 dark:hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>

                        <div class="group relative hidden lg:block">
                            <a href="/basket" class="relative block rounded-full p-2 hover:bg-gray-100 transition-all duration-200 dark:hover:bg-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600 hover:text-gray-900 transition-colors duration-200 dark:text-gray-400 dark:hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                <span data-basket-count-badge class="absolute -top-1 -right-1 {{ $globalBasketCount > 0 ? 'flex' : 'hidden' }} h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                                    {{ $globalBasketCount }}
                                </span>
                            </a>

                            @if ($showBasketPreview)
                                <div data-basket-preview-panel class="invisible absolute right-0 top-full z-50 mt-3 w-[25rem] translate-y-2 rounded-3xl border border-gray-200 bg-white p-4 text-gray-900 opacity-0 shadow-2xl transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                    @include('partials.basket-preview-panel', [
                                        'basketPreview' => $globalBasketPreview,
                                        'basketCount' => $globalBasketCount,
                                        'basketSubtotal' => $globalBasketSubtotal,
                                    ])
                                </div>
                            @endif
                        </div>

                        <a href="/basket" class="relative rounded-full p-2 hover:bg-gray-100 transition-all duration-200 dark:hover:bg-white/10 lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-600 hover:text-gray-900 transition-colors duration-200 dark:text-gray-400 dark:hover:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <span data-basket-count-badge class="absolute -top-1 -right-1 {{ $globalBasketCount > 0 ? 'flex' : 'hidden' }} h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                                {{ $globalBasketCount }}
                            </span>
                        </a>
                    </div>

                </div>
            </div>

            <div id="mobile-menu-panel" class="hidden border-t border-gray-200 pt-3 mt-3 space-y-3 md:hidden dark:border-white/10">
                <div class="grid grid-cols-2 gap-2">
                    <a href="/" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">Home</a>
                    <a href="/store" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">Store</a>
                    <a href="/build-guide" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">Build Guide</a>
                    <a href="{{ route('part-picker') }}" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">Part Picker</a>
                    <a href="/about" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">About</a>
                    <a href="/contact" class="rounded-lg px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 dark:bg-white/10 dark:text-gray-100">Contact</a>
                </div>

                @guest
                    <div class="flex flex-col gap-2">
                        <a href="/login" class="rounded-lg px-4 py-2 text-center text-sm font-semibold bg-gray-900 text-white dark:bg-white dark:text-gray-900">Sign In</a>
                        <a href="/register" class="rounded-lg px-4 py-2 text-center text-sm font-medium border border-gray-300 text-gray-700 dark:border-white/20 dark:text-gray-300">Register</a>
                    </div>
                @endguest

                @auth
                    <p class="text-sm text-gray-600 dark:text-gray-300">Signed in as {{ auth()->user()->first_name ?? 'User' }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-4 py-2 text-sm font-medium border border-red-400/40 text-red-600 dark:text-red-300">Sign Out</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

{{ $slot }}

<script>
    (function () {
        // Ensure theme is initialized on pages that don't render x-header.
        var root = document.documentElement;
        if (!root.classList.contains('dark') && !root.classList.contains('light-theme-initialized')) {
            try {
                var storedTheme = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var useDark = storedTheme ? storedTheme === 'dark' : prefersDark;
                root.classList.toggle('dark', useDark);
            } catch (error) {
                root.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches);
            }
            root.classList.add('light-theme-initialized');
        }
        //initialises the correct logo based on the current view mode toggled (light/dark)
        var useDark = root.classList.contains('dark');
        var logo = document.getElementById('main-logo');
        if (logo) {
            logo.src = useDark ? "{{ asset('images/logo-removebg-preview.png') }}" : "{{ asset('images/lightmodelogo.png') }}";
        }

        if (typeof window.toggleTheme !== 'function') {
            window.toggleTheme = function () {
                var willBeDark = !root.classList.contains('dark');
                root.classList.toggle('dark', willBeDark);

                try {
                    localStorage.setItem('theme', willBeDark ? 'dark' : 'light');

                } catch (error) {
                    // Ignore storage errors.
                }
            };
        }

        var navContainer = document.getElementById('main-nav-links');
        var indicator = document.getElementById('main-nav-active-pill');
        if (navContainer && indicator) {
            var navLinks = navContainer.querySelectorAll('[data-nav-link]');

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

            var activeLink = navContainer.querySelector('[data-active="true"]');
            requestAnimationFrame(function () {
                moveIndicator(activeLink);
            });

            navLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    moveIndicator(link);
                });
            });

            window.addEventListener('resize', function () {
                var currentActive = navContainer.querySelector('[data-active="true"]');
                moveIndicator(currentActive);
            });
        }

        var mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        var mobileMenuPanel = document.getElementById('mobile-menu-panel');
        var mobileMenuOpenIcon = document.getElementById('mobile-menu-open-icon');
        var mobileMenuCloseIcon = document.getElementById('mobile-menu-close-icon');
        if (mobileMenuToggle && mobileMenuPanel && mobileMenuOpenIcon && mobileMenuCloseIcon) {
            var setMobileMenu = function (isOpen) {
                mobileMenuPanel.classList.toggle('hidden', !isOpen);
                mobileMenuOpenIcon.classList.toggle('hidden', isOpen);
                mobileMenuCloseIcon.classList.toggle('hidden', !isOpen);
                mobileMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            };

            setMobileMenu(false);
            mobileMenuToggle.addEventListener('click', function () {
                setMobileMenu(mobileMenuPanel.classList.contains('hidden'));
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    setMobileMenu(false);
                }
            });
        }
        //looks out for any mode changes seperately from the isToggle function to change the logo specifically
        var observer = new MutationObserver(function(modeChanges) {
            modeChanges.forEach(function(modeChange) {
                if (modeChange.attributeName === "class") {
                    var isDark = document.documentElement.classList.contains('dark');
                    var logo = document.getElementById('main-logo');
                    if (logo) {
                        logo.src = isDark ? "{{ asset('images/logo-removebg-preview.png') }}"  : "{{ asset('images/lightmodelogo.png') }}";
                    }
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });

        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!(form instanceof HTMLFormElement) || form.dataset.basketAsync !== 'true') {
                return;
            }

            event.preventDefault();

            var actionUrl = form.getAttribute('action');
            var method = (form.getAttribute('method') || 'POST').toUpperCase();
            if (!actionUrl) {
                return;
            }

            fetch(actionUrl, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(form),
                credentials: 'same-origin',
            })
                .then(function (response) {
                    return response.json().then(function (payload) {
                        if (!response.ok) {
                            throw payload;
                        }

                        return payload;
                    });
                })
                .then(function (payload) {
                    document.querySelectorAll('[data-basket-count-badge]').forEach(function (badge) {
                        if (payload.basketCount > 0) {
                            badge.textContent = payload.basketCount;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    });

                    var previewPanel = document.querySelector('[data-basket-preview-panel]');
                    if (previewPanel && typeof payload.basketPreviewHtml === 'string') {
                        previewPanel.innerHTML = payload.basketPreviewHtml;
                    }

                    var basketPage = document.querySelector('[data-basket-page]');
                    if (basketPage && typeof payload.basketPageHtml === 'string') {
                        basketPage.innerHTML = payload.basketPageHtml;
                    }
                })
                .catch(function (payload) {
                    if (payload && payload.message) {
                        window.alert(payload.message);
                    }
                });
        });
    })();


</script>


