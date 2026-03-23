<x-header></x-header>
<x-layout>
    <section class="bg-gray-100 py-10 transition-colors duration-300 dark:bg-gray-950 md:py-12">
        <main class="container mx-auto max-w-6xl px-4">
            <div class="mb-8 md:mb-10">
                <h1 class="text-center text-3xl font-extrabold text-gray-800 dark:text-white sm:text-4xl">Your Shopping Basket</h1>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">Review your items and continue to checkout when ready.</p>
            </div>

            @if (session('error'))
                <div class="mx-auto mb-6 max-w-4xl">
                    <div class="rounded-lg border-l-4 border-red-500 bg-red-100 p-4 text-red-700 shadow-sm dark:bg-red-900/40 dark:text-red-200" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div data-basket-page>
                @include('partials.basket-page-content', ['basket' => $basket])
            </div>
        </main>
    </section>
</x-layout>
<x-footer></x-footer>
