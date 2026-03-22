<x-header></x-header>

<x-layout>
<style>
    /* make the input html field incrementer invisible for all browser types*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* make it easier to grab the slider icons*/
    input[type='range'] {
    pointer-events: none;
    }

    input[type='range']::-webkit-slider-thumb {
        pointer-events: auto;
    }

</style>

    @livewire('store')

</x-layout>

<x-footer></x-footer>


