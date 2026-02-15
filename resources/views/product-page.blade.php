

    <x-header></x-header>

    <x-layout>

        @if (session('success'))
            <div class="container mx-auto px-6 mt-4">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="container mx-auto px-6 mt-4">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <main class="container mx-auto px-6 py-8 max-w-7xl">
            <x-product-page-breadcrumb />


            <form method="POST" action="{{ route('basket.add') }}">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1"> <!-- doing 1 for now -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">

                    @php
                        $title = $product->product_name;
                        $brandName = $product->product_model;
                        $image = $product->product_image;
                        $description = !empty($product->product_description) ? $product->product_description : 'This item is still in development.';
                        $price = $product->product_price;
                        $stock = $product->product_stock;
                        $colour = $product->product_colour;
                    @endphp

                    <x-product-page-gallery
                    :image=$image
                    />

                    <div class="flex flex-col pt-2">

                        <x-product-page-header
                        :title=$title
                        :brandName=$brandName
                        review="69" />

                        <p class="text-gray-700 text-lg mb-10">{{$description}}</p>

                        <x-product-page-variant-selecter
                        variant1={{$colour}}
                        />

                        <x-product-page-purchase-actions
                        :stock=$stock
                        :price=$price />
                    </div>
                </div>
            </form>
        </main>
    </x-layout>

    <x-footer></x-footer>


