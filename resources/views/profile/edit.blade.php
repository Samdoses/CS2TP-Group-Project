<x-header></x-header>
<x-layout>
<div class="bg-gray-100 dark:bg-gray-800 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 dark:text-white">My Account</h1>
        <br>
        <p class="text-gray-600 mb-8 dark:text-gray-300">Manage your account settings, order history, and customer support messages.</p>

        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-6">
            <aside>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden dark:border-gray-700 dark:bg-gray-900">
                    <nav class="flex flex-col">
                        <a href="{{ route('profile.index') }}"
                            class="{{ request()->routeIs('profile.index') ? 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }} text-left px-6 py-4 font-medium transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-user-circle mr-2"></i> Profile Information
                        </a>

                        <a href="{{ route('profile.security') }}"
                            class="{{ request()->routeIs('profile.security') ? 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }} text-left px-6 py-4 font-medium transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-lock mr-2"></i> Security Information
                        </a>

                        <a href="{{ route('profile.orders') }}"
                            class="{{ request()->routeIs('profile.orders') ? 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }} text-left px-6 py-4 font-medium transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-box-open mr-2"></i> Order History
                        </a>

                        <a href="{{ route('profile.reviews') }}"
                            class="{{ request()->routeIs('profile.reviews') ? 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }} text-left px-6 py-4 font-medium transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-star mr-2"></i> Reviews
                        </a>

                        <a href="{{ route('profile.messages') }}"
                            class="{{ request()->routeIs('profile.messages') ? 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }} flex items-center justify-between px-6 py-4 font-medium transition-colors duration-200 focus:outline-none">
                            <span><i class="fas fa-envelope mr-2"></i> My Messages</span>
                            @if(($unreadReplyCount ?? 0) > 0)
                                <span class="rounded-full bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white">{{ $unreadReplyCount }}</span>
                            @endif
                        </a>
                    </nav>
                </div>
            </aside>

            <main>
                @if(request()->routeIs('profile.index'))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
                        @include('profile.partials.update-profile')
                    </div>
                @endif

                @if(request()->routeIs('profile.security'))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
                        @include('profile.partials.update-password')
                    </div>
                @endif

                @if(request()->routeIs('profile.orders'))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
                        @include('profile.partials.order-history')
                    </div>
                @endif

                @if(request()->routeIs('profile.reviews'))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
                        @include('profile.partials.my-reviews')
                    </div>
                @endif

                @if(request()->routeIs('profile.messages'))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 dark:border-gray-700 dark:bg-gray-900">
                        @include('profile.partials.my-messages')
                    </div>
                @endif
            </main>
        </div>
        <div>
            <div class="mt-4">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 transition duration-200 font-bold focus:outline-none flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</x-layout>
<x-footer></x-footer>
