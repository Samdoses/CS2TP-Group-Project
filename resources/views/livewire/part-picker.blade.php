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

                            <div class="p-5 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800">

                                <div>
                                    @if($activeCategory === $key)

                                    <div class="w-full bg grey-50 dark:bg-gray-900 border-t border-b border-grey-200 dark:border-gray-700 max-h-96 overflow-y-auto">

                                        @forelse($availableProducts as $product)

                                            <div class="w-full flex items-center justify-between p-4 border-b last:border-0 border-gray-200 dark:border-gray-700 hover:bg-blue-50 transition cursor-pointer"
                                                wire:click="selectPart('{{ $key }}', {{ $product->id }})">

                                                <img src="{{ $product->product_image }}"
                                                    class="w-16 h-16 object-cover rounded shrink-0 border bg-white">

                                                <div class="ml-4 flex-1 min-w-0">

                                                    <div class="text-sm font-bold text-gray-900">
                                                        {{ $product->product_name }}
                                                    </div>

                                                    <div class="text-xs text-gray-500 mt-1 flex gap-2 flex-wrap">
                                                        @foreach($product->specs->take(3) as $spec)
                                                            <span class="bg-gray-200 px-2 py-0.5 rounded text-gray-700">
                                                                {{ ucfirst(str_replace('_', ' ', $spec->spec_key)) }}:
                                                                {{ $spec->spec_value }}
                                                            </span>
                                                        @endforeach
                                                    </div>

                                                </div>

                                                <div class="text-right">

                                                    <div class="font-bold text-gray-900">
                                                        £{{ number_format($product->product_price, 2) }}
                                                    </div>

                                                    <div class="text-blue-600 text-xs font-bold mt-1">
                                                        Select part
                                                    </div>

                                                </div>

                                            </div>

                                        @empty

                                            <div class="p-6 text-center text-gray-500 text-sm">
                                                No compatible parts found.
                                            </div>

                                        @endforelse

                                    </div>
                                    @endif
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
