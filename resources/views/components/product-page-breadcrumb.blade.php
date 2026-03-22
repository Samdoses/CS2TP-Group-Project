<!--The navigation between the different levels of the storepage (WIP)-->

@php
    $categoryName = match($product->category_id) {
    1 => 'Computer Components',
    2 => 'Prebuilt PCs',
    3 => 'Bundles',
    default => 'Other'
    };
@endphp

<nav class="flex items-center text-sm mb-10 text-black dark:text-white" aria-label="Breadcrumb">
    <ol class="flex items-center">
        <li class="flex items-center">
            <a href="/" class="hover:underline">Home</a>
            <svg class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </li>
        <li class="flex items-center">
            <a href="/store" class="hover:underline">All products</a>
            <svg class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </li>
        <li class="flex items-center">
            <a href="/store?selectedCategories[0]={{$product->category_id}}" class="hover:underline">{{$categoryName}}</a>
            <svg class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </li>
        <li>
            <span class="underline underline-offset-4 decoration-1" aria-current="page">{{ $product->product_name }}</span>
        </li>
    </ol>
</nav>
