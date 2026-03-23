@php
    $categoryName = match ($product->category_id) {
        1 => 'Computer Components',
        2 => 'Prebuilt PCs',
        3 => 'Bundles',
        default => 'Other',
    };
@endphp

<nav class="mb-8" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <li>
            <a href="/" class="transition hover:text-slate-900 dark:hover:text-white">Home</a>
        </li>
        <li aria-hidden="true" class="text-slate-300 dark:text-slate-600">/</li>
        <li>
            <a href="/store" class="transition hover:text-slate-900 dark:hover:text-white">Store</a>
        </li>
        <li aria-hidden="true" class="text-slate-300 dark:text-slate-600">/</li>
        <li>
            <a href="/store?selectedCategories[0]={{ $product->category_id }}" class="transition hover:text-slate-900 dark:hover:text-white">
                {{ $categoryName }}
            </a>
        </li>
    </ol>
</nav>
