<div> <div class="relative min-h-screen w-full bg-gray-200/50 dark:bg-gray-800/50">

    <div class="relative min-h-screen w-full">
              <div class="min-h-screen py-8 sm:py-10 px-4">

            <!-- MAIN GRID -->
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- LEFT SIDE CONTENT -->
                <div class="lg:col-span-3 space-y-6">

                    <!-- HEADER / PROGRESS -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                            PC Part Picker
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Select compatible components to build your custom PC and see the estimated total price.
                        </p>

                        @php
                            $selectedCount = count($selected);
                            $totalParts = count($categories);
                            $progress = max(0, min(100, ($selectedCount / $totalParts) * 100));
                            $complete = $selectedCount === $totalParts;
                        @endphp

                        <p class="text-sm text-gray-500 mt-4 mb-2">
                            {{ $selectedCount }} / {{ $totalParts }} parts selected
                        </p>

                        <!-- PROGRESS BAR -->
                        <div class="relative w-full h-6 bg-gray-200 rounded-full overflow-hidden">

                            <div
                                class="absolute left-0 top-0 h-full transition-all duration-700 ease-out {{ $complete ? 'bg-green-500' : 'bg-yellow-400' }}"
                                style="width: {{ $progress }}%">
                            </div>

                            @if(!$complete)
                                <div
                                    class="absolute transition-all duration-700 ease-out"
                                    style="left: calc({{ $progress }}% - 8px); top:50%; transform:translateY(-50%);">
                                    🐭
                                </div>
                            @endif

                            <div
                                class="absolute"
                                style="right:6px; top:50%; transform:translateY(-50%);">
                                🧀
                            </div>

                        </div>

                        @if($complete)
                            <p class="text-green-600 text-sm mt-2 font-semibold">
                                Build complete!
                            </p>
                        @endif

                    </div>

                    <!-- TOTAL + ACTIONS -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col sm:flex-row justify-between items-center gap-4">

                        <div>
                            <div class="text-sm text-gray-500">Estimated Total</div>

                            <div class="text-2xl font-semibold text-gray-900">
                                £{{ number_format($this->total, 2) }}
                            </div>
                        </div>

                        <div class="flex gap-3">

                            @if(count($selected) > 0)
                                <button wire:click="clearBuild"
                                    class="px-4 py-3 bg-red-50 text-red-600 hover:bg-red-100 font-semibold rounded-lg border border-red-200">
                                    Clear Build
                                </button>
                            @endif

                            @if(count($selected) === count($categories))
                                <button wire:click="addAllToBasket"
                                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                                    Add Build to Basket
                                </button>
                            @else
                                <button disabled
                                    class="px-6 py-3 bg-gray-200 text-gray-500 font-semibold rounded-lg">
                                    Select Parts ({{ count($selected) }}/{{ count($categories) }})
                                </button>
                            @endif

                        </div>

                    </div>

                    <!-- PART PICKER TABLE -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm divide-y">

                        <div class="bg-blue-50 text-blue-800 text-sm px-5 py-3 rounded-t-xl">
                            Compatibility filter is active. Only compatible parts are shown.
                        </div>

                        @foreach($categories as $key => $data)

                           <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center gap-4">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $data['label'] }}
                                        </div>

                                        @if(isset($selected[$key]))
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                {{ $selected[$key]['name'] }}
                                                <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">
                                                    £{{ number_format($selected[$key]['price'], 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                                                No part selected
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex gap-3">
                                        <button
                                            wire:click="selectCategory('{{ $key }}')"
                                            class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-900 text-white hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600">
                                            {{ isset($selected[$key]) ? 'Change' : 'Choose' }}
                                        </button>

                                        @if(isset($selected[$key]))
                                            <button
                                                wire:click="removePart('{{ $key }}')"
                                                class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-200">
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($activeCategory === $key)
                                <div class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-5 py-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                                        @forelse($availableProducts as $product)
                                            <div
                                                wire:click="selectPart('{{ $key }}', {{ $product->id }})"
                                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition cursor-pointer">

                                                <div class="flex items-start gap-3">
                                                    <img src="{{ $product->product_image }}"
                                                        class="w-16 h-16 object-cover rounded border bg-white">

                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                            {{ $product->product_name }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex flex-wrap gap-1">
                                                            @foreach($product->specs->take(3) as $spec)
                                                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 rounded-lg">
                                                                    {{ ucfirst(str_replace('_', ' ', $spec->spec_key)) }}: {{ $spec->spec_value }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-3 flex items-center justify-between">
                                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                        £{{ number_format($product->product_price, 2) }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                                                        Select part
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-span-full text-center text-sm text-gray-500 dark:text-gray-400">
                                                No compatible parts found.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>

                </div>



                <!-- RIGHT SIDEBAR -->
                <div class="lg:col-span-1">

                    <div class="sticky top-24 bg-white border border-gray-200 rounded-xl shadow-sm p-5">

                        <h2 class="text-lg font-semibold text-gray-900 mb-4">
                            Current Build
                        </h2>

                        <div class="space-y-2">

                            @foreach($categories as $key => $data)

                                <div class="flex justify-between items-center text-sm bg-gray-50 rounded-lg px-3 py-2">

                                    <span class="font-medium text-gray-700">
                                        {{ $data['label'] }}
                                    </span>

                                    @if(isset($selected[$key]))
                                        <span class="text-green-600 text-xs font-semibold truncate max-w-[120px] text-right">
                                            {{ $selected[$key]['name'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            —
                                        </span>
                                    @endif

                                </div>

                            @endforeach

                        </div>

                        <div class="border-t my-4"></div>

                        <div class="flex justify-between items-center">

                            <span class="text-sm text-gray-600">Estimated Total</span>

                            <span class="text-lg font-bold text-gray-900">
                                £{{ number_format($this->total, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
