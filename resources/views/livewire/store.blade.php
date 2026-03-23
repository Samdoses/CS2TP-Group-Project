<div class="relative min-h-screen w-full overflow-hidden bg-slate-100/80 dark:bg-slate-950/80">
    <style>
        .store-range {
            pointer-events: none;
        }

        .store-range::-webkit-slider-runnable-track {
            height: 0.375rem;
            background: transparent;
        }

        .store-range::-moz-range-track {
            height: 0.375rem;
            background: transparent;
        }

        .store-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            pointer-events: auto;
            margin-top: -0.4rem;
            height: 1.15rem;
            width: 1.15rem;
            border-radius: 9999px;
            border: 2px solid rgb(255 255 255 / 0.95);
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.35);
            cursor: pointer;
        }

        .store-range::-moz-range-thumb {
            pointer-events: auto;
            height: 1.15rem;
            width: 1.15rem;
            border-radius: 9999px;
            border: 2px solid rgb(255 255 255 / 0.95);
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.35);
            cursor: pointer;
        }
    </style>

    <div class="relative z-10">
        @if (session('success'))
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6">
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6">
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
            <section class="rounded-3xl border border-gray-200 bg-white/95 p-6 shadow-sm backdrop-blur dark:border-gray-800 dark:bg-gray-900/95">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div class="relative w-full xl:max-w-2xl">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Search by name, model, part, category, or description"
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pl-12 pr-12 text-sm text-gray-900 outline-none transition focus:border-gray-500 focus:ring-4 focus:ring-gray-500/10 dark:border-gray-700 dark:bg-slate-950 dark:text-white"
                        >
                        @if ($search !== '')
                            <button wire:click="clearSearch" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 transition hover:text-gray-600 dark:hover:text-gray-200" type="button">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.293a1 1 0 00-1.414-1.414L10 8.586 7.707 6.293a1 1 0 00-1.414 1.414L8.586 10l-2.293 2.293a1 1 0 101.414 1.414L10 11.414l2.293 2.293a1 1 0 001.414-1.414L11.414 10l2.293-2.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <div class="lg:hidden">
                            <button id="store-filters-toggle" type="button" class="w-full rounded-full border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-slate-950 dark:text-gray-100 dark:hover:bg-white/5">
                                Show Filters
                            </button>
                        </div>

                        <label class="flex items-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-slate-950 dark:text-gray-300">
                            <input wire:model.live="inStockOnly" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            In stock only
                        </label>

                        <div class="flex items-center gap-3">
                            <label for="store-sort" class="text-sm font-medium text-gray-600 dark:text-gray-300">Sort</label>
                            <select id="store-sort" wire:model.live="sortOption" class="rounded-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition focus:border-gray-500 dark:border-gray-700 dark:bg-slate-950 dark:text-gray-200">
                                @foreach ($sortOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if ($activeFilters !== [])
                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Active filters:</span>
                        @foreach ($activeFilters as $filter)
                            <button
                                type="button"
                                wire:key="active-filter-{{ $filter['key'] }}"
                                wire:click='{{ $filter['clearAction'] }}'
                                class="inline-flex items-center gap-2 rounded-full border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:bg-slate-950 dark:text-gray-300 dark:hover:bg-white/5"
                            >
                                <span>{{ $filter['label'] }}</span>
                                <span class="text-xs">&times;</span>
                            </button>
                        @endforeach

                        <button type="button" wire:click="resetFilters" class="ml-1 text-sm font-semibold text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
                            Clear all
                        </button>
                    </div>
                @endif
            </section>

            <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-[300px_minmax(0,1fr)]">
                <aside id="store-filters-panel" class="hidden lg:block">
                    <div class="sticky top-28 space-y-5 rounded-3xl border border-gray-200 bg-white/95 p-5 shadow-sm backdrop-blur dark:border-gray-800 dark:bg-gray-900/95">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Filters</h2>
                            </div>
                            <button wire:click="resetFilters" type="button" class="text-xs font-semibold uppercase tracking-wide text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
                                Reset
                            </button>
                        </div>

                        <x-filter-group title="Category" open class="rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
                            <div class="space-y-2">
                                @foreach ($categories as $category)
                                    <label wire:key="cat-{{ $category->id }}" class="flex items-center justify-between gap-3 rounded-xl px-2 py-1.5 transition hover:bg-white dark:hover:bg-white/5">
                                        <span class="flex items-center gap-3">
                                            <input
                                                type="checkbox"
                                                wire:click="toggleCategory({{ $category->id }})"
                                                @checked(in_array($category->id, $selectedCategories, true))
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            >
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->category_name }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </x-filter-group>

                        <x-filter-group title="Price" open class="rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
                            <div class="space-y-4">
                                <div>
                                    <div class="relative flex h-10 items-center">
                                        <div class="absolute h-1.5 w-full rounded-full bg-gray-200 dark:bg-gray-700"></div>
                                        <input
                                            type="range"
                                            min="{{ $minPrice }}"
                                            max="{{ $maxPrice }}"
                                            wire:model.live="selectedMinPrice"
                                            class="store-range absolute w-full appearance-none bg-transparent"
                                        >
                                        <input
                                            type="range"
                                            min="{{ $minPrice }}"
                                            max="{{ $maxPrice }}"
                                            wire:model.live="selectedMaxPrice"
                                            class="store-range absolute w-full appearance-none bg-transparent"
                                        >
                                    </div>
                                    <div class="mt-2 flex justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        <span>&pound;{{ number_format($minPrice) }}</span>
                                        <span>&pound;{{ number_format($maxPrice) }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-3">
                                    <div class="flex items-center rounded-full border border-gray-200 bg-white px-3 py-2 dark:border-gray-700 dark:bg-slate-950">
                                        <span class="mr-2 text-xs text-gray-400">&pound;</span>
                                        <input type="number" min="{{ $minPrice }}" max="{{ $maxPrice }}" wire:model.live.debounce.300ms="selectedMinPrice" class="w-full border-none bg-transparent p-0 text-sm text-gray-700 outline-none focus:ring-0 dark:text-gray-200">
                                    </div>
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">to</span>
                                    <div class="flex items-center rounded-full border border-gray-200 bg-white px-3 py-2 dark:border-gray-700 dark:bg-slate-950">
                                        <span class="mr-2 text-xs text-gray-400">&pound;</span>
                                        <input type="number" min="{{ $minPrice }}" max="{{ $maxPrice }}" wire:model.live.debounce.300ms="selectedMaxPrice" class="w-full border-none bg-transparent p-0 text-right text-sm text-gray-700 outline-none focus:ring-0 dark:text-gray-200">
                                    </div>
                                </div>
                            </div>
                        </x-filter-group>

                        <x-filter-group title="Minimum Rating" open class="rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ([4, 3, 2, 1] as $rating)
                                    <button
                                        type="button"
                                        wire:click="$set('minimumRating', {{ $rating }})"
                                        class="rounded-xl border px-3 py-2 text-sm font-medium transition {{ $minimumRating === $rating ? 'border-indigo-500 bg-indigo-50 text-indigo-700 dark:border-indigo-400 dark:bg-indigo-500/10 dark:text-indigo-200' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-slate-950 dark:text-gray-300 dark:hover:bg-white/5' }}"
                                    >
                                        {{ $rating }}+ stars
                                    </button>
                                @endforeach
                            </div>
                        </x-filter-group>

                        <x-filter-group title="Primary Colour" open class="rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
                            <div class="space-y-2">
                                @foreach ($colours as $colour)
                                    <label wire:key="colour-{{ md5($colour) }}" class="flex items-center justify-between gap-3 rounded-xl px-2 py-1.5 transition hover:bg-white dark:hover:bg-white/5">
                                        <span class="flex items-center gap-3">
                                            <input
                                                type="checkbox"
                                                wire:click='toggleColours(@json($colour))'
                                                @checked(in_array($colour, $selectedColours, true))
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            >
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $colour }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </x-filter-group>

                        <x-filter-group title="PC Part" open class="rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
                            <div class="space-y-2">
                                @foreach ($pcParts as $part)
                                    <label wire:key="part-{{ md5($part) }}" class="flex items-center justify-between gap-3 rounded-xl px-2 py-1.5 transition hover:bg-white dark:hover:bg-white/5">
                                        <span class="flex items-center gap-3">
                                            <input
                                                type="checkbox"
                                                wire:click='togglePcParts(@json($part))'
                                                @checked(in_array($part, $selectedPCParts, true))
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            >
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $part }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </x-filter-group>
                    </div>
                </aside>

                <main>
                    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($filteredCount) }} {{ \Illuminate\Support\Str::plural('product', $filteredCount) }} found
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Sorted by {{ strtolower($sortOptions[$sortOption] ?? 'featured') }}.
                            </p>
                        </div>
                    </div>

                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($products as $item)
                                <form method="POST" action="{{ route('basket.add') }}">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="1">

                                    @php
                                        $tagline = !empty($item->product_tagline) ? $item->product_tagline : 'This item is still in development.';
                                        $avgRating = (float) ($item->reviews_avg_rating ?? 0);
                                    @endphp

                                    <div class="flex h-full transform flex-col transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                                        <a href="{{ route('product.show', $item->id) }}" class="flex-grow">
                                            <x-product-card
                                                :title="$item->product_name"
                                                :tagline="$tagline"
                                                :price="number_format($item->product_price, 2)"
                                                :image="$item->product_image"
                                                :avgRating="$avgRating"
                                                :stock="$item->product_stock"
                                                :category="$item->category?->category_name"
                                                :part="$item->product_part"
                                                :context="'store'"
                                            />
                                        </a>
                                    </div>
                                </form>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="rounded-3xl border border-dashed border-gray-300 bg-white/90 px-6 py-14 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900/90">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">No products match those filters</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Try widening your price range, removing some filters, or searching with a broader term.
                            </p>
                            <button wire:click="resetFilters" type="button" class="mt-6 inline-flex rounded-full bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                                Reset filters
                            </button>
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

