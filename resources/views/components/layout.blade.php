<body>

    <nav class="bg-gray-800 text-white p-4 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <div class="flex items-center space-x-6">

            <a href="/" class="flex-shrink-0">
                <img src="{{ asset ('images/logo-removebg-preview.png') }}" alt="Happy Hardware" class="h-20 w-auto">
            </a>


            <a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Home</a>
            <a href="/store" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Store</a>
            <a href="/about" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">About</a>
            <a href="/contact" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Contact</a>
        </div>

        <div class="flex items-center space-x-6">

            @guest
                <a href="/login" class="rounded-md px-3 py-2 text-sm font-medium bg-white text-gray-800 hover:bg-gray-200 transition">Sign In</a>
                <a href="/register" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition">Register</a>
            @endguest

            @auth
                <span class="text-sm font-medium text-gray-300">Welcome, {{ auth()->user()->first_name ?? 'User' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-red-500 hover:text-white transition">
                        Sign Out
                    </button>
                </form>
            @endauth

            <a href="/profile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 cursor-pointer text-gray-300 hover:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>

            <a href="/basket">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-8 h-8 cursor-pointer text-gray-300 hover:text-white">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </a>

        </div>
    </div>
    </nav>

    {{ $slot }}
</body>
