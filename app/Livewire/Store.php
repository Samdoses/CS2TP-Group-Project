<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Store extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'categories', except: [])]
    public array $selectedCategories = [];

    #[Url(as: 'colours', except: [])]
    public array $selectedColours = [];

    #[Url(as: 'parts', except: [])]
    public array $selectedPCParts = [];

    #[Url(as: 'min')]
    public $selectedMinPrice = null;

    #[Url(as: 'max')]
    public $selectedMaxPrice = null;

    #[Url(as: 'sort', except: 'featured')]
    public string $sortOption = 'featured';

    #[Url(as: 'stock', except: false)]
    public bool $inStockOnly = false;

    #[Url(as: 'rating', except: 0)]
    public int $minimumRating = 0;

    public int $minPrice = 0;
    public int $maxPrice = 0;
    public $categories;
    public $colours;
    public $pcParts;

    public function mount(): void
    {
        $this->categories = Category::query()->orderBy('category_name')->get();
        $this->colours = Product::query()
            ->whereNotNull('product_colour')
            ->where('product_colour', '!=', 'N/A')
            ->distinct()
            ->orderBy('product_colour')
            ->pluck('product_colour');
        $this->pcParts = Product::query()
            ->whereNotNull('product_part')
            ->where('product_part', '!=', 'N/A')
            ->distinct()
            ->orderBy('product_part')
            ->pluck('product_part');

        $this->minPrice = (int) (Product::min('product_price') ?? 0);
        $this->maxPrice = (int) (Product::max('product_price') ?? 0);

        $this->selectedMinPrice = is_numeric($this->selectedMinPrice) ? (int) $this->selectedMinPrice : $this->minPrice;
        $this->selectedMaxPrice = is_numeric($this->selectedMaxPrice) ? (int) $this->selectedMaxPrice : $this->maxPrice;

        $this->normalizePriceRange();
        $this->normalizeSortOption();
    }

    public function sortBy(string $option): void
    {
        $this->resetPage();
        $this->sortOption = $option;
        $this->normalizeSortOption();
    }

    public function toggleCategory(int $categoryId): void
    {
        $this->toggleArrayValue('selectedCategories', $categoryId);
    }

    public function toggleColours(string $colourName): void
    {
        $this->toggleArrayValue('selectedColours', $colourName);
    }

    public function togglePcParts(string $partName): void
    {
        $this->toggleArrayValue('selectedPCParts', $partName);
    }

    public function clearCategory(int $categoryId): void
    {
        $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$categoryId]));
        $this->resetPage();
    }

    public function clearColour(string $colour): void
    {
        $this->selectedColours = array_values(array_diff($this->selectedColours, [$colour]));
        $this->resetPage();
    }

    public function clearPcPart(string $part): void
    {
        $this->selectedPCParts = array_values(array_diff($this->selectedPCParts, [$part]));
        $this->resetPage();
    }

    public function clearMinimumRating(): void
    {
        $this->minimumRating = 0;
        $this->resetPage();
    }

    public function clearInStockOnly(): void
    {
        $this->inStockOnly = false;
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function clearPriceRange(): void
    {
        $this->selectedMinPrice = $this->minPrice;
        $this->selectedMaxPrice = $this->maxPrice;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->selectedCategories = [];
        $this->selectedColours = [];
        $this->selectedPCParts = [];
        $this->selectedMinPrice = $this->minPrice;
        $this->selectedMaxPrice = $this->maxPrice;
        $this->sortOption = 'featured';
        $this->inStockOnly = false;
        $this->minimumRating = 0;

        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedColours(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedPCParts(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedMinPrice(): void
    {
        $this->normalizePriceRange('min');
        $this->resetPage();
    }

    public function updatedSelectedMaxPrice(): void
    {
        $this->normalizePriceRange('max');
        $this->resetPage();
    }

    public function updatedSortOption(): void
    {
        $this->normalizeSortOption();
        $this->resetPage();
    }

    public function updatedInStockOnly(): void
    {
        $this->resetPage();
    }

    public function updatedMinimumRating(): void
    {
        $this->minimumRating = max(0, min(4, (int) $this->minimumRating));
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()
            ->with('category')
            ->withAvg(['reviews' => function ($query) {
                $query->where('review_status', 'Approved');
            }], 'rating');

        if ($this->search !== '') {
            $query->where(function ($innerQuery) {
                $term = '%' . trim($this->search) . '%';

                $innerQuery->where('product_name', 'like', $term)
                    ->orWhere('product_model', 'like', $term)
                    ->orWhere('product_description', 'like', $term)
                    ->orWhere('product_tagline', 'like', $term)
                    ->orWhere('product_part', 'like', $term)
                    ->orWhereHas('category', function ($categoryQuery) use ($term) {
                        $categoryQuery->where('category_name', 'like', $term);
                    });
            });
        }

        if ($this->selectedCategories !== []) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if ($this->selectedColours !== []) {
            $query->whereIn('product_colour', $this->selectedColours);
        }

        if ($this->selectedPCParts !== []) {
            $query->whereIn('product_part', $this->selectedPCParts);
        }

        if ($this->inStockOnly) {
            $query->where('product_stock', '>', 0);
        }

        if (is_numeric($this->selectedMinPrice) && is_numeric($this->selectedMaxPrice)) {
            $query->whereBetween('product_price', [(int) $this->selectedMinPrice, (int) $this->selectedMaxPrice]);
        }

        if ($this->minimumRating > 0) {
            $query->whereIn('products.id', Review::query()
                ->select('product_id')
                ->where('review_status', 'Approved')
                ->groupBy('product_id')
                ->havingRaw('AVG(rating) >= ?', [$this->minimumRating]));
        }

        if ($this->sortOption === 'featured') {
            $query->orderByRaw('CASE WHEN product_stock > 0 THEN 0 ELSE 1 END')
                ->orderByDesc('product_createdate')
                ->orderBy('product_name');
        } else {
            [$sortField, $sortDirection] = $this->sortParts();
            $query->orderBy($sortField, $sortDirection);

            if ($sortField !== 'product_name') {
                $query->orderBy('product_name');
            }
        }

        $products = $query->paginate(9);
        $filteredCount = $products->total();

        return view('livewire.store', [
            'products' => $products,
            'filteredCount' => $filteredCount,
            'activeFilters' => $this->activeFilters(),
            'sortOptions' => $this->sortOptions(),
        ]);
    }

    private function toggleArrayValue(string $property, string|int $value): void
    {
        $this->resetPage();

        if (! in_array($value, $this->{$property}, true)) {
            $this->{$property}[] = $value;
            return;
        }

        $this->{$property} = array_values(array_diff($this->{$property}, [$value]));
    }

    private function normalizePriceRange(?string $source = null): void
    {
        $this->selectedMinPrice = is_numeric($this->selectedMinPrice) ? (int) $this->selectedMinPrice : $this->minPrice;
        $this->selectedMaxPrice = is_numeric($this->selectedMaxPrice) ? (int) $this->selectedMaxPrice : $this->maxPrice;

        $this->selectedMinPrice = max($this->minPrice, min($this->selectedMinPrice, $this->maxPrice));
        $this->selectedMaxPrice = max($this->minPrice, min($this->selectedMaxPrice, $this->maxPrice));

        if ($this->selectedMinPrice > $this->selectedMaxPrice) {
            if ($source === 'min') {
                $this->selectedMaxPrice = $this->selectedMinPrice;
            } else {
                $this->selectedMinPrice = $this->selectedMaxPrice;
            }
        }
    }

    private function normalizeSortOption(): void
    {
        if (! array_key_exists($this->sortOption, $this->sortOptions())) {
            $this->sortOption = 'featured';
        }
    }

    private function sortOptions(): array
    {
        return [
            'featured' => 'Featured',
            'newest' => 'Newest first',
            'name_asc' => 'Name A-Z',
            'name_desc' => 'Name Z-A',
            'price_asc' => 'Price low to high',
            'price_desc' => 'Price high to low',
            'rating_desc' => 'Highest rated',
        ];
    }

    private function sortParts(): array
    {
        return match ($this->sortOption) {
            'newest' => ['product_createdate', 'desc'],
            'name_desc' => ['product_name', 'desc'],
            'price_asc' => ['product_price', 'asc'],
            'price_desc' => ['product_price', 'desc'],
            'rating_desc' => ['reviews_avg_rating', 'desc'],
            default => ['product_createdate', 'desc'],
        };
    }

    private function activeFilters(): array
    {
        $filters = [];

        if ($this->search !== '') {
            $filters[] = [
                'key' => 'search',
                'label' => 'Search: ' . $this->search,
                'clearAction' => 'clearSearch',
            ];
        }

        foreach ($this->categories as $category) {
            if (in_array($category->id, $this->selectedCategories, true)) {
                $filters[] = [
                    'key' => 'category-' . $category->id,
                    'label' => $category->category_name,
                    'clearAction' => 'clearCategory(' . $category->id . ')',
                ];
            }
        }

        foreach ($this->selectedColours as $colour) {
            $filters[] = [
                'key' => 'colour-' . md5($colour),
                'label' => 'Colour: ' . $colour,
                'clearAction' => 'clearColour(' . json_encode($colour) . ')',
            ];
        }

        foreach ($this->selectedPCParts as $part) {
            $filters[] = [
                'key' => 'part-' . md5($part),
                'label' => 'Part: ' . $part,
                'clearAction' => 'clearPcPart(' . json_encode($part) . ')',
            ];
        }

        if ($this->inStockOnly) {
            $filters[] = [
                'key' => 'stock-only',
                'label' => 'In stock only',
                'clearAction' => 'clearInStockOnly',
            ];
        }

        if ($this->minimumRating > 0) {
            $filters[] = [
                'key' => 'rating-' . $this->minimumRating,
                'label' => $this->minimumRating . '+ stars',
                'clearAction' => 'clearMinimumRating',
            ];
        }

        if ((int) $this->selectedMinPrice !== $this->minPrice || (int) $this->selectedMaxPrice !== $this->maxPrice) {
            $filters[] = [
                'key' => 'price',
                'label' => 'GBP ' . number_format((int) $this->selectedMinPrice) . ' - GBP ' . number_format((int) $this->selectedMaxPrice),
                'clearAction' => 'clearPriceRange',
            ];
        }

        return $filters;
    }
}

