@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $description }}</p>
</div>
