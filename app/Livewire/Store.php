<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class Store extends Component
{

    use WithPagination;

    public $search = '';

    #[Url]
    public $selectedCategories = [];

    public $minPrice;
    public $maxPrice;

    //have to manually update this with smallest and largest prices
    //url doesnt take variables
    #[Url(except: 2500)]
    public $selectedMaxPrice = 2500;
    #[Url(except: 10)]
    public $selectedMinPrice = 10;
    public $categories;


    #[Url]
    public $selectedColours = [];
    public $colours;

    #[Url]
    public $selectedPCParts = [];
    public $pcParts;

    public $sortField = 'product_name';
    public $sortDirection = 'asc';
    public $showSort = false;

    public function mount() {

        $this->categories = Category::all();
        $this->minPrice = Product::min('product_price');
        $this->maxPrice = Product::max('product_price');
        //$this->selectedMaxPrice = $this->maxPrice;
        //$this->selectedMinPrice = $this->minPrice;
        $this->colours = Product::select('product_colour')->distinct()->pluck('product_colour');
        $this->pcParts = Product::select('product_part')->distinct()->pluck('product_part');
    }

    public function toggleSort() {
        $this->resetPage();
        $this->showSort = !$this->showSort;
    }

    public function toggleCategory($categoryId) {
        $this->resetPage();
        if (!in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories[] = $categoryId;
        }
        else {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        }
    }

    public function toggleColours($colourName) {
        $this->resetPage();
        if (!in_array($colourName, $this->selectedColours)) {
            $this->selectedColours[] = $colourName;
        }
        else {
            $this->selectedColours = array_diff($this->selectedColours, [$colourName]);
        }
    }

    public function togglePcParts($pcName) {
        $this->resetPage();
         if (!in_array($pcName, $this->selectedPCParts)) {
            $this->selectedPCParts[] = $pcName;
        }
        else {
            $this->selectedPCParts = array_diff($this->selectedPCParts, [$pcName]);
        }
    }

    public function sortBy($field, $direction) {
        $this->resetPage();
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    //automatically resets pagination when the variables change
    public function updatingSearch() { $this->resetPage(); }
    public function updatingSelectedCategories() { $this->resetPage(); }
    public function updatingSelectedColours() { $this->resetPage(); }
    public function updatingSelectedPCParts() { $this->resetPage(); }
    public function updatingSelectedMaxPrice() { $this->resetPage(); }

    public function updated($propertyName)
    {
        //validation checks for the price filter
        //if it just reset the values dont run validaiton yet
        if ($this->selectedMinPrice === null || $this->selectedMaxPrice === null) {
        return;
        }
        //makes sure min is not greater than max value
        if ($this->selectedMaxPrice > $this->maxPrice) {
            $this->selectedMaxPrice = $this->maxPrice;
        }
        if ($this->selectedMinPrice < $this->minPrice) {
            $this->selectedMinPrice = $this->minPrice;
        }

        if ($this->selectedMinPrice > $this->selectedMaxPrice) {
            if ($propertyName === 'selectedMinPrice') {
                $this->selectedMaxPrice = $this->selectedMinPrice;
            }
            else {
                $this->selectedMinPrice = $this->selectedMaxPrice;
            }
        }
    }
    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedColours = [];
        $this->selectedPCParts = [];

        $this->selectedMinPrice = $this->minPrice;
        $this->selectedMaxPrice = $this->maxPrice;

        $this->resetPage();
    }

    public function render()
    {
        //split up filters and use queries
        //we reference the reviews here so that the store page always has access to its review average
        $query = Product::query()
        ->withAvg(['reviews' => function ($query) {
            $query->where('review_status', 'Approved');
        }], 'rating');

        if (!empty($this->search)){
            $query->where(function ($q) {
            $q->where('product_name', 'like', '%' . $this->search . '%')
                ->orWhere('product_description', 'like', '%' . $this->search . '%');
            });

        }

        if (!empty($this->selectedCategories)) {
             $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedColours)) {
            $query->whereIn('product_colour', $this->selectedColours);
        }

        if (!empty($this->selectedPCParts)) {
            $query->whereIn('product_part', $this->selectedPCParts);
        }

        //price filter
        //only filter by price if sliders have been moved
        if (is_numeric($this->selectedMinPrice) || is_numeric($this->selectedMaxPrice)) {
                $query->whereBetween('product_price', [
                    $this->selectedMinPrice ?? $this->minPrice,
                    $this->selectedMaxPrice ?? $this->maxPrice
                ]);
        }

        return view('livewire.store', [
            'products' => $query->orderBy($this->sortField, $this->sortDirection)->paginate(9),
        ]);
    }
}
