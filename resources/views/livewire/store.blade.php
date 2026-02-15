<div>
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

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Store</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Sidebar Filter -->
            <aside class="md:col-span-1">
                <h2 class="text-2xl font-bold mb-4">Filter</h2>
                <x-filter-group title="Category" open>
                    @foreach ($categories as $category)
                        <label class="flex items-center space-x-3 mb-2 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:click="toggleCategory({{ $category->id}})"
                                @if(in_array($category->id, $selectedCategories)) checked @endif
                                class="form-checkbox h-4 w-4 text-gray-800 border-gray-300 rounded focus:ring-gray-800">


                            <span class="text-gray-700">{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </x-filter-group>

                <x-filter-group title="Price" open>

                    <div class="px-1">
                        <div class="px-2 space-y-2">
                                <input type="range" id="price-range" name="max_price" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="£{{ $selectedMaxPrice }}"
                                wire:model.lazy="selectedMaxPrice"
                                class="w-full h-2 bg-gray-200 rounded-lh accent-indigo-600" oninput="document.getElementById('price-display').innerText = '£' + this.value">

                                <div class="flex justify-between text-sm text-gray-700 font-semibold">

                                        <span>£{{ $minPrice }}</span>
                                        <span id="price-display">£{{ $selectedMaxPrice }}</span>

                                </div>
                        </div>
                    </div>

                </x-filter-group>

                <x-filter-group title="Primary Colour" open>
                    @foreach ($colours as $colour)
                        <!-- displays all available colours except for the objects that have a irrelevant colour -->
                        @if ($colour != 'N/A')
                        <label class="flex items-center space-x-3 mb-2 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:click="toggleColours('{{ $colour }}')"
                                @if(in_array($colour, $selectedColours))checked @endif
                                class="form-checkbox h-4 w-4 text-gray-800 border-gray-300 rounded focus:ring-gray-800">


                            <span class="text-gray-700">{{ $colour }}</span>
                        </label>
                        @endif
                    @endforeach
                </x-filter-group>

                 <x-filter-group title="PC Part" open>
                    @foreach ($pcParts as $part)
                        <!-- displays all available colours except for the objects that have a irrelevant colour -->
                        @if ($part != 'N/A')
                        <label class="flex items-center space-x-3 mb-2 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:click="togglePcParts('{{ $part }}')"
                                @if(in_array($part, $selectedPCParts))checked @endif
                                class="form-checkbox h-4 w-4 text-gray-800 border-gray-300 rounded focus:ring-gray-800">


                            <span class="text-gray-700">{{ $part }}</span>
                        </label>
                        @endif
                    @endforeach
                </x-filter-group>

                <h2 class="text-2xl font-bold mb-4">Sort By</h2>

                <x-filter-group title="Filters">
                        <div class="relative inline-block text-left">
                        <label>

                                <button wire:click="sortBy('product_name', 'asc')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100
                                {{$sortField == 'product_name' && $sortDirection == 'asc' ? 'border-2 border-blue-500 rounded-lg' : '' }}">
                                    Name A-Z
                                </button>

                                <button wire:click="sortBy('product_name', 'desc')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100
                                {{$sortField == 'product_name' && $sortDirection == 'desc' ? 'border-2 border-blue-500 rounded-lg' : '' }}">
                                    Name Z-A
                                </button>

                                <button wire:click="sortBy('product_price', 'desc')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100
                                {{$sortField == 'product_price' && $sortDirection == 'desc' ? 'border-2 border-blue-500 rounded-lg' : '' }}">
                                    Price ↑
                                </button>

                                <button wire:click="sortBy('product_price', 'asc')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100
                                {{$sortField == 'product_price' && $sortDirection == 'asc' ? 'border-2 border-blue-500 rounded-lg' : '' }}">
                                    Price ↓
                                </button>

                        </label>
                    </div>
                </x-filter-group>
            </aside>

            <!-- Main Content Area -->
            <main class="md:col-span-3">

                <!-- Top Bar: Search & Sort -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <div class="relative w-full md:w-1/2">
                        <input
                            wire:model.live="search"
                            type="text"
                            placeholder="Search products..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-gray-500 focus:border-gray-500"
                        >
                    </div>


                </div>

                <!-- Product Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $item)

                            <form method="POST" action="{{ route('basket.add') }}">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <input type="hidden" name="quantity" value="1">

                                @php
                                    $title = $item->product_name;
                                    $image = $item->product_image;
                                    $price = $item->product_price;
                                    $description = !empty($item->product_description) ? $item->product_description : 'This item is still in development.';
                                @endphp

                                <div class="transform transition duration-200 hover:scale-105 hover:shadow-lg">
                                    <a href="{{ route('product.show', $item->id)}}" class="block">
                                        <x-product-card
                                            :title="$title"
                                            :description="$description"
                                            :price="$price"
                                            :image="$image"
                                            :context="'store'"

                                        />
                                    </a>
                                </div>

                            </form>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="text-gray-500">We couldn't find any products. Try adjusting your search or checking other categories.</p>
                    </div>
                @endif

            </main>
        </div>
    </div>
</div>
