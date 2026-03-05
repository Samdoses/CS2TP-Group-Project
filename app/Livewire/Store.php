<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class Store extends Component
{

    use WithPagination;

    public $search = '';
    public $selectedCategories = [];
    public $minPrice;
    public $maxPrice;
    public $selectedMaxPrice;
    public $categories;

    public $selectedColours = [];
    public $colours;

    public $selectedPCParts = [];
    public $pcParts;

    public $sortField = 'product_name';
    public $sortDirection = 'asc';
    public $showSort = false;

    public function mount() {

        $this->categories = Category::all();
        $this->minPrice = Product::min('product_price');
        $this->maxPrice = Product::max('product_price');
        $this->selectedMaxPrice = $this->maxPrice;
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


    public function render()
    {
        //split up filters and use queries
        $query = Product::query();

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

        $query->when($this->minPrice !== null && $this->selectedMaxPrice !== null, function ($q) {
            $q->whereBetween('product_price', [$this->minPrice, $this->selectedMaxPrice]);
        }
        );

        return view('livewire.store', [
            'products' => $query->orderBy($this->sortField, $this->sortDirection)->paginate(9),
        ]);
    }
}
