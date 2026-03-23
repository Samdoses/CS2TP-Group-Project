<x-admin-layout title="Admin Products">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
            <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 xl:col-span-2">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Catalogue</p>
                        <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Product Management</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Review, add, and remove products from the storefront.</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">{{ $products->total() }} products</span>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-left text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                <th class="py-3 pr-4">Image</th>
                                <th class="py-3 pr-4">Name</th>
                                <th class="py-3 pr-4">Part</th>
                                <th class="py-3 pr-4">Category</th>
                                <th class="py-3 pr-4">Price</th>
                                <th class="py-3 pr-4">Stock</th>
                                <th class="py-3 pr-4">Specs</th>
                                <th class="py-3 pr-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="border-b border-gray-100 align-top hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/5">
                                    <td class="py-3 pr-4">
                                        @if ($product->product_image)
                                            <img src="{{ Str::startsWith($product->product_image, ['http://', 'https://', '/']) ? $product->product_image : asset($product->product_image) }}" alt="{{ $product->product_name }}" class="h-14 w-14 rounded-xl object-cover">
                                        @else
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 text-xs text-gray-500 dark:bg-white/5 dark:text-gray-400">No image</div>
                                        @endif
                                    </td>
                                    <td class="py-3 pr-4 font-medium text-gray-900 dark:text-white">{{ $product->product_name }}</td>
                                    <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $product->product_part }}</td>
                                    <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $product->category->category_name ?? 'Uncategorised' }}</td>
                                    <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">&pound;{{ number_format($product->product_price, 2) }}</td>
                                    <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $product->product_stock }}</td>
                                    <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $product->specs->count() }}</td>
                                    <td class="py-3 pr-4">
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Remove this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full bg-red-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-red-500">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-gray-500 dark:text-gray-400">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">{{ $products->links() }}</div>
            </section>

            <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Add Product</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create a new catalogue item with a file upload for the product image.</p>

                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input name="product_name" value="{{ old('product_name') }}" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Model</label>
                        <input name="product_model" value="{{ old('product_model') }}" class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <input type="number" min="0" name="product_price" value="{{ old('product_price') }}" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                            <input type="number" min="0" name="product_stock" value="{{ old('product_stock') }}" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Part Type</label>
                            <select id="part_type_select" name="product_part" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                                <option value="" disabled {{ old('product_part') ? '' : 'selected' }}>Select Part</option>
                                <option value="N/A" @selected(old('product_part') == 'N/A')>N/A</option>
                                <option value="CPU" @selected(old('product_part') == 'CPU')>CPU</option>
                                <option value="GPU" @selected(old('product_part') == 'GPU')>GPU</option>
                                <option value="RAM" @selected(old('product_part') == 'RAM')>RAM</option>
                                <option value="Motherboard" @selected(old('product_part') == 'Motherboard')>Motherboard</option>
                                <option value="Storage" @selected(old('product_part') == 'Storage')>Storage</option>
                                <option value="PSU" @selected(old('product_part') == 'PSU')>PSU</option>
                                <option value="Case" @selected(old('product_part') == 'Case')>Case</option>
                                <option value="Cooling Fan" @selected(old('product_part') == 'Cooling Fan')>Cooling Fan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                            <input name="product_colour" value="{{ old('product_colour') }}" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select id="category_select" name="category_id" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Image</label>
                        <input type="file" name="product_image" accept="image/*" class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-gray-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-gray-700 dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Upload a JPG, PNG, GIF, or WebP image up to 4MB.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tagline</label>
                        <input name="product_tagline" value="{{ old('product_tagline') }}" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="product_description" rows="4" required class="mt-1 w-full rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white">{{ old('product_description') }}</textarea>
                    </div>

                    <div id="specs-container">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Specifications</label>
                        <div id="specs-list" class="mt-2 space-y-2">
                        </div>
                        <button type="button" id="add-spec-btn" class="mt-2 rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700 hover:bg-gray-300 dark:bg-white/10 dark:text-gray-300">Add Specification</button>
                    </div>

                    <button type="submit" class="w-full rounded-full bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900">Add Product</button>
                </form>
            </section>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const categorySelect = document.getElementById('category_select');
                const partTypeSelect = document.getElementById('part_type_select');
                const componentCategoryName = 'Computer Components';
                if (!categorySelect || !partTypeSelect) return;

                categorySelect.addEventListener('change', function () {
                    const selectedText = this.options[this.selectedIndex].text;
                    if (selectedText === componentCategoryName) {
                        partTypeSelect.classList.remove('bg-gray-100', 'cursor-not-allowed', 'pointer-events-none');
                        if (partTypeSelect.value === 'N/A') {
                            partTypeSelect.value = '';
                        }
                    } else {
                        partTypeSelect.value = 'N/A';
                        partTypeSelect.classList.add('bg-gray-100', 'cursor-not-allowed', 'pointer-events-none');
                    }
                });

                categorySelect.dispatchEvent(new Event('change'));

                const specsContainer = document.getElementById('specs-list');
                const addSpecBtn = document.getElementById('add-spec-btn');
                let specIndex = 0;

                addSpecBtn.addEventListener('click', function() {
                    addSpecRow();
                });

                function addSpecRow(key = '', value = '') {
                    const row = document.createElement('div');
                    row.className = 'flex gap-2 items-center';
                    row.innerHTML = `
                        <input type="text" name="specs[${specIndex}][key]" value="${key}" placeholder="Spec name (e.g., Core Count)"
                               class="flex-1 rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white" required>
                        <input type="text" name="specs[${specIndex}][value]" value="${value}" placeholder="Spec value (e.g., 8)"
                               class="flex-1 rounded-xl border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-950 dark:text-white" required>
                        <button type="button" class="remove-spec-btn rounded-full bg-red-600 px-2 py-1 text-xs font-medium text-white hover:bg-red-500">×</button>
                    `;
                    specsContainer.appendChild(row);
                    specIndex++;

                    row.querySelector('.remove-spec-btn').addEventListener('click', function() {
                        row.remove();
                    });
                }

                addSpecRow();
            });
        </script>
    @endpush
</x-admin-layout>

