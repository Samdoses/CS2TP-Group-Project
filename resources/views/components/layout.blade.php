<!--The nav bar-->
<body>

    <nav class="bg-gray-800 text-white p-4 shadow-md">
    <div class="max-w-7x1 mx-auto flex justify-between item-center">

        <div class="flex items-center space-x-6">
            <a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Home</a>
            <a href="/store" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Store</a>
            <a href="/about" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">About</a>
            <a href="/contact" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Contact</a>
            <a href="/cc" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Component Chooser</a>
        </div>

        <div class="flex item-center space-x-6">

            <a href="/profile" class="text-gray-200 hover:text-white transition">
                <img src="{{ asset('images/account.png') }}" alt="Account" class="w-6 h-6">
            </a>

            <a href="/basket" class="text-gray-200 hover:text-white transition">
                <img src="{{ asset('images/basket.png') }}" alt="Basket" class="w-6 h-6">

            </a>
        </div>
    </div>
    </nav>

    {{ $slot }}
</body>
