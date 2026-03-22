<!--The individual checkboxes-->
@props(['label', 'name'])

<label class="flex items-center space-x-3 mb-3 cursor-pointer">
    <input type="checkbox"
           name="{{ $name }}"
           class="form-checkbox h-4 w-4 text-gray-800 border-gray-300 rounded focus:ring-gray-800">
    <span class="text-gray-700">{{ $label }}</span>
</label>
