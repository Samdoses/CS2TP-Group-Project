@if (session('success'))
        <div class="container mx-auto px-6 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
@endif

<div class="min-h-screen bg-gray-50 py-10 px-4">

    <div class="max-w-6xl mx-auto space-y-8">

        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                PC Part Picker
            </h1>
            <p class="text-gray-500 mt-2">
                Select compatible components to build your custom PC and see the estimated total price.
        </div>

        <!-- Summary Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex justify-between items-center">
            <div>
                <div class="text-sm text-gray-500">Estimated Total</div>
                <div class="text-2xl font-semibold text-gray-900">
                    £{{ number_format($this->total, 2) }}
                </div>
            </div>
        </div>

        <!-- Parts Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm divide-y">

            @foreach($categories as $key => $label)
                <div class="p-5 flex items-center justify-between hover:bg-gray-50 transition">

                    <!-- Left Side -->
                    <div>
                        <div class="font-semibold text-gray-900">
                            {{ $label }}
                        </div>

                        @if(isset($selected[$key]))
                            <div class="text-sm text-gray-600 mt-1">
                                {{ $selected[$key]['name'] }}
                                <span class="ml-2 font-medium text-gray-900">
                                    £{{ number_format($selected[$key]['price'], 2) }}
                                </span>
                            </div>
                        @else
                            <div class="text-sm text-gray-400 mt-1">
                                No part selected
                            </div>
                        @endif
                    </div>

                    <!-- Right Side -->
                    <div class="flex gap-3">

                        <button
                            wire:click="selectPart('{{ $key }}')"
                            class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition"
                        >
                            {{ isset($selected[$key]) ? 'Change' : 'Choose' }}
                        </button>

                        @if(isset($selected[$key]))
                            <button
                                wire:click="removePart('{{ $key }}')"
                                class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-100 transition"
                            >
                                Remove
                            </button>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>

    </div>

</div>
