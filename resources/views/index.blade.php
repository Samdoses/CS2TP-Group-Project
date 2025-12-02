<x-header></x-header>

<x-layout>

    <div class="grid grid-cols-1 md:grid-cols-2 bg-gray-200 mb-12">


    <div class="h-67 overflow-hidden">
        <img src="/images/cool_pc.jpg" alt="Cool PC" class="w-full h-full object-cover">
    </div>

    <div class="p-12 flex flex-col justify-center">

    <h1 class="text-4xl font-bold mb-4 text-gray-900">
        "Power Your Dreams, One Build at a Time. "
    </h1>

    <p class="text-gray-600 mb-8">
            We offer the best prices on CPUs, GPUs and pre-builts. Better service, better gaming.
    </p>

    <div class="flex gap-4">
        <a href="/store" class="bg-gray-900 text-white px-6 py-3 rounded hover:bg-gray-700">
            Shop Now
        </a>
        <a href="/cc" class="bg-gray-900 text-white px-6 py-3 rounded hover:bg-gray-600">
            Computer Configurator
        </a>
    </div>
    </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

            <a href="/store" class="block group">
                <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                    <span class="text-gray-500 font-bold text-xl">Components</span>
                </div>

                <h3 class="text-lg font-semibold">Shop Individual Parts</h3>
            </a>

            <a href="/store" class="block group">
                <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                    <span class="text-gray-500 font-bold text-xl">Bundles</span>
                </div>

                <h3 class="text-lg font-semibold">Save with Bundles</h3>
            </a>

            <a href="/store" class="block group">
                <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                    <span class="text-gray-500 font-bold text-xl">Pre-Builts</span>
                </div>

                <h3 class="text-lg font-semibold">Ready to Game</h3>
            </a>
        </div>

    </div>

    <div class="bg-gray-100 py-12 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-center mb-10">Best Sellers</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <x-product-card
                    title="Popular Pre-Built"
                    description="Ready to game straight out the box."
                    price="£1300"
                    image="null"
                    />

                <x-product-card
                    title="Popular CPU"
                    description="High pefformance CPU for gaming and productivity."
                    price="£300"
                    image="null"
                    />

                <x-product-card
                    title="Popular GPU"
                    description="Next-gen graphics power."
                    price="£600"
                    image="null"
                    />

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 text-center">

        <h2 class="text-3xl font-bold mb-4">Not sure where to start?</h2>
        <p class="text-gray-600 mb-12">Save your time of researching, and use our resources to configure your computer.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <div class="flex flex-col item-center">
            <div class="bg-gray-100 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <img src="/images/box.png" alt="Bundles Icon" class="w-10 h-10">
            </div>
            <p class="bg-gray-100 p-2 px-4 rounded text-sm">Purchase Bundles, chosen by our experts</p>
        </div>

        <div class="flex flex-col item-center">
            <div class="bg-gray-100 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <img src="/images/refresh.png" alt="Configurator Icon" class="w-10 h-10">
            </div>
            <p class="bg-gray-100 p-2 px-4 rounded text-sm">Configure and check for compactibility to build your dream PC</p>
        </div>

        <div class="flex flex-col item-center">
            <div class="bg-gray-100 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <img src="/images/search.png" alt="Guides Icon" class="w-10 h-10">
            </div>
            <p class="bg-gray-100 p-2 px-4 rounded text-sm">To learn the essentials of building a PC, read our guides.</p>
        </div>

    </div>

    <div class="mt-12">
        <a href="/cc" class="bg-gray-800 text-white px-8 py-3 rounded hover:bg-gray-700 transition">
            Start Now
        </a>
    </div>







</x-layout>

<x-footer></x-footer>
