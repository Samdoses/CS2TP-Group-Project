
<div class="relative min-h-screen w-full overflow-hidden">
    <x-video-background lightOpacity="opacity-10" darkOpacity="opacity-30" />

<div class="relative z-10">
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

        <div class="container mx-auto px-4 py-6 sm:px-6">
        <h1 class="text-2xl sm:text-3xl font-bold mb-5 sm:mb-6">Store</h1>

        <div class="mb-4">
            <button id="store-filters-toggle" type="button" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 shadow-sm dark:bg-white/10 dark:text-gray-100">
                Show Filters
            </button>
        </div>

        <div class="grid grid-cols-1 gap-6 md:gap-8">

            <!-- Sidebar Filter -->
            <aside id="store-filters-panel" class="hidden">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold">Filter</h2>
                    <button wire:click="resetFilters" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-wider">
                        Reset All
                    </button>
                </div>
                <x-filter-group title="Category" open>
                    @foreach ($categories as $category)
                        <label wire:key="cat-{{ $category->id }}-{{ count($selectedCategories) }}"  class="flex items-center space-x-3 mb-2 cursor-pointer">
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
                    <div class="px-1 space-y-2">

                        <div wire:key="price-range-{{ $selectedMinPrice ?? 'min' }}-{{ $selectedMaxPrice ?? 'max'}}">
                            <div class="relative h-10 w-full flex items-center justify-center">
                                <div class="absolute w-full h-1.5 bg-gray-300 rounded-lg"></div>

                                <input type="range" wire:key="min-slider" min="{{ $minPrice }}" max="{{ $maxPrice }}" wire:model.live="selectedMinPrice" value="{{ $selectedMinPrice ?? $minPrice }}"
                                    class="absolute w-full appearance-none bg-transparent pointer-events-none cursor-pointer accent-indigo-600 z-20 [&::-webkit-slider-thumb]:pointer-events-auto"
                                >

                                <input type="range" wire:key="max-slider"  min="{{ $minPrice }}" max="{{ $maxPrice }}" wire:model.live="selectedMaxPrice" value="{{ $selectedMaxPrice ?? $maxPrice }}"
                                    class="absolute w-full appearance-none bg-transparent pointer-events-none cursor-pointer accent-indigo-600 z-10 [&::-webkit-slider-thumb]:pointer-events-auto"
                                >
                            </div>

                            <div class="flex justify-between text-sm text-gray-700 font-semibold">
                                <span>£{{$minPrice }}</span>
                                <span>£{{$maxPrice }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center flex-1 bg-white border border-gray-200 rounded-full px-3 transition-all focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500/10">
                                <span class=" text-gray-400 text-xs">£</span>
                                <input type="number" wire:model.live.debounce.500ms="selectedMinPrice" value="{{ $selectedMinPrice ?? $minPrice }}" placeholder="{{ $minPrice }}"
                                    class="w-full bg-transparent text-xs border-none focus:ring-0 p-1 outline-none text-gray-700">
                            </div>
                            <div class="py-1">
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-tighter shrink-0">to</span>
                            </div>
                            <div class="flex items-center flex-1 bg-white border border-gray-200 rounded-full px-3 transition-all focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500/10">
                                <span class=" text-gray-400 text-xs">£</span>
                                <input type="number" wire:model.live.debounce.500ms="selectedMaxPrice" value="{{ $selectedMaxPrice ?? $maxPrice }}" placeholder="{{ $maxPrice }}"
                                    class="w-full bg-transparent text-xs border-none focus:ring-0 p-1 outline-none text-gray-700 text-right">
                            </div>
                        </div>
                    </div>
                </x-filter-group>

                <x-filter-group title="Primary Colour" open>
                    @foreach ($colours as $colour)
                        <!-- displays all available colours except for the objects that have a irrelevant colour -->
                        @if ($colour != 'N/A')
                        <label wire:key="col-{{ Str::slug($colour) }}-{{ count($selectedColours) }}" class="flex items-center space-x-3 mb-2 cursor-pointer">
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
                        <label wire:key="part-{{ Str::slug($part) }}-{{ count($selectedPCParts) }}" class="flex items-center space-x-3 mb-2 cursor-pointer">
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
                        <div class="relative inline-block text-left w-full">
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
            <main>

                <!--Top Bar: Searching & Sorting-->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 sm:mb-8 gap-4">
                    <div class="relative w-full md:w-2/3 group">
                        <!-- the search icon -->
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            wire:model.live="search"
                            type="text"
                            placeholder="Search products..."
                            class="w-full pl-12 pr-11 px-4 py-2.5 leading-5 border dark:bg-white/10 border-gray-300 rounded-md focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200"
                        >
                        <!-- adds an x button that clears the search-->
                        @if($search)
                            <button
                                wire:click="$set('search', '')"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </div>


                </div>

                <!-- Product Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                        @foreach($products as $item)

                            <form method="POST" action="{{ route('basket.add') }}">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <input type="hidden" name="quantity" value="1">

                                @php
                                    $title = $item->product_name;
                                    $image = $item->product_image;
                                    $price = number_format($item->product_price, 2);
                                    $tagline = !empty($item->product_tagline) ? $item->product_tagline : 'This item is still in development.';
                                    $avgRating = $item->reviews_avg_rating ?? 0;

                                @endphp

                                <div class="h-full transform transition duration-200 hover:scale-105 hover:shadow-lg flex flex-col">
                                    <a href="{{ route('product.show', $item->id)}}" class="flex-grow">
                                        <x-product-card
                                            :title="$title"
                                            :tagline="$tagline"
                                            :price="$price"
                                            :image="$image"
                                            :avgRating="$avgRating"
                                            :context="'store'"

                                        />
                                    </a>
                                </div>

                            </form>
                        @endforeach
                    </div>
                     <div class="mt-6">
                            {{ $products->links() }}
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
</div>

<script>
    (function () {
        function bindStoreFilterToggle() {
            var toggleButton = document.getElementById('store-filters-toggle');
            var filtersPanel = document.getElementById('store-filters-panel');
            if (!toggleButton || !filtersPanel || toggleButton.dataset.bound === 'true') {
                return;
            }

            toggleButton.dataset.bound = 'true';
            toggleButton.setAttribute('aria-expanded', 'false');

            toggleButton.addEventListener('click', function () {
                var willShow = filtersPanel.classList.contains('hidden');
                filtersPanel.classList.toggle('hidden', !willShow);
                toggleButton.textContent = willShow ? 'Hide Filters' : 'Show Filters';
                toggleButton.setAttribute('aria-expanded', willShow ? 'true' : 'false');
            });
        }

        bindStoreFilterToggle();
        document.addEventListener('livewire:navigated', bindStoreFilterToggle);
        document.addEventListener('livewire:initialized', bindStoreFilterToggle);
    })();
</script>
