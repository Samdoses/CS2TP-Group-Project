<x-header></x-header>

<x-layout>
<main class="container mx-auto px-6 py-8 max-w-7xl">
    <x-product-page-breadcrumb />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
        <x-product-page-gallery />

        <div class="flex flex-col pt-2">
            <x-product-page-header
            title="Popular Pre-Built"
            brandName="UwU corp"
            review="69" />

            <p class="text-gray-700 text-lg mb-10">Description...</p>

            <x-product-page-variant-selecter
            variant1="good"
            variant2="less good" />

            <x-product-page-purchase-actions
            quantity="1"
            price="100" />
        </div>
    </div>
</main>
</x-layout>

<x-footer></x-footer>