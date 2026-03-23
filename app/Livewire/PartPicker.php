<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Basket;
use App\Models\BasketItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Session;

class PartPicker extends Component
{

    public function addAllToBasket()
    {
        // 1. Safety check to ensure all categories are selected
        if (count($this->selected) !== count($this->categories)) {
            session()->flash('error', 'Please select all parts before adding to the basket.');
            return;
        }

        // 2. MUST CHECK AUTH: Your database requires a valid user_id to create a basket.
        if (!\Illuminate\Support\Facades\Auth::check()) {
            // If they aren't logged in, redirect them to login with a helpful message
            session()->flash('error', 'Please log in to add your custom build to your basket.');
            return redirect()->route('login');
        }

        // 3. Get or create the basket for the currently logged-in user
        $basket = \App\Models\Basket::firstOrCreate([
            'user_id' => \Illuminate\Support\Facades\Auth::id()
        ]);

        // 4. Loop through the selected parts and add them to the basket items table
        foreach ($this->selected as $categoryKey => $part) {

            $basketItem = \App\Models\BasketItem::where('basket_id', $basket->id)
            ->where('product_id', $part['id'])
            ->first();

            if ($basketItem) {
                // If they already have this specific part in their basket, increment quantity
                $basketItem->increment('quantity');
            } else {
                // Otherwise, create a new basket item
                \App\Models\BasketItem::create([
                    'basket_id' => $basket->id,
                    'product_id' => $part['id'],
                    'quantity' => 1,
                ]);
            }
        }

        // 5. Clear the PC builder session array so they can start a fresh build later
        $this->selected = [];
        $this->activeCategory = null;

        // 6. Redirect to the basket page with a success message
        session()->flash('success', 'Your custom PC build has been added to your basket!');
        return redirect()->to('/basket');
    }
    public array $categories = [
        'cpu' => ['label' => 'CPU', 'db_name' => 'CPU'],
        'motherboard' => ['label' => 'Motherboard', 'db_name' => 'Motherboard'],
        'ram' => ['label' => 'Memory (RAM)', 'db_name' => 'RAM'],
        'gpu' => ['label' => 'Graphics Card', 'db_name' => 'GPU'],
        'ssd' => ['label' => 'Storage (SSD)', 'db_name' => 'SSD'],
        'psu' => ['label' => 'Power Supply', 'db_name' => 'PSU'],
        'case' => ['label' => 'PC Case', 'db_name' => 'Case'],
        'fan' => ['label' => 'Cooling Fan', 'db_name' => 'Cooling Fan'],
    ];

    #[Session]
    public array $selected = [];
    public $activeCategory = null;

    public function selectCategory($key)
    {
        $this->activeCategory = ($this->activeCategory === $key) ? null : $key;
    }

    public function selectPart($categoryKey, $productId)
    {
        $product = Product::with('specs')->find($productId);

        // Store specs in lowercase so they are easy to search later
        $specs = [];
        foreach($product->specs as $spec) {
            $specs[strtolower(trim($spec->spec_key))] = trim($spec->spec_value);
        }

        $this->selected[$categoryKey] = [
            'id' => $product->id,
            'name' => $product->product_name,
            'price' => $product->product_price,
            'image' => $product->product_image,
            'specs' => $specs,
        ];

        $this->activeCategory = null;
    }

    public function removePart($category)
    {
        unset($this->selected[$category]);
    }

    public function clearBuild()
    {
        // Empty the selected array to clear the session
        $this->selected = [];

        // Close any open dropdowns
        $this->activeCategory = null;

        // Give the user a quick confirmation message
        session()->flash('success', 'Your build has been cleared. You can start fresh!');
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->selected, 'price'));
    }

    // NEW: Helper function to fuzzily find a spec value by keyword
    private function findSpecValue($specs, $keywords) {
        foreach ($specs as $key => $value) {
            foreach ($keywords as $keyword) {
                if (str_contains($key, $keyword)) {
                    return $value;
                }
            }
        }
        return null;
    }

    private function applyCompatibilityFilters(Builder $query, $category)
    {
        // 1. CPU & Motherboard Socket Compatibility
        if ($category === 'cpu' && isset($this->selected['motherboard'])) {
            $socket = $this->findSpecValue($this->selected['motherboard']['specs'], ['socket']);
            if ($socket) {
                $query->whereHas('specs', function($q) use ($socket) {
                    $q->where('spec_key', 'LIKE', '%socket%')
                    ->where('spec_value', 'LIKE', '%' . $socket . '%');
                });
            }
        }

        if ($category === 'motherboard' && isset($this->selected['cpu'])) {
            $socket = $this->findSpecValue($this->selected['cpu']['specs'], ['socket']);
            if ($socket) {
                $query->whereHas('specs', function($q) use ($socket) {
                    $q->where('spec_key', 'LIKE', '%socket%')
                    ->where('spec_value', 'LIKE', '%' . $socket . '%');
                });
            }
        }

        // 2. RAM & Motherboard Memory Type Compatibility
        if ($category === 'ram' && isset($this->selected['motherboard'])) {
            $memoryString = $this->findSpecValue($this->selected['motherboard']['specs'], ['memory', 'ram', 'type']);

            if ($memoryString) {
                // Extract just "DDR4" or "DDR5" to ignore speeds like "6000MHz" or text like "Supports"
                preg_match('/DDR\d/i', $memoryString, $matches);
                $ddrVersion = $matches[0] ?? $memoryString;

                $query->whereHas('specs', function($q) use ($ddrVersion) {
                    $q->where(function($subQuery) {
                        $subQuery->where('spec_key', 'LIKE', '%memory%')
                        ->orWhere('spec_key', 'LIKE', '%ram%')
                        ->orWhere('spec_key', 'LIKE', '%type%');
                    })->where('spec_value', 'LIKE', '%' . $ddrVersion . '%');
                });
            }
        }

        if ($category === 'motherboard' && isset($this->selected['ram'])) {
            $memoryString = $this->findSpecValue($this->selected['ram']['specs'], ['memory', 'ram', 'type']);

            if ($memoryString) {
                preg_match('/DDR\d/i', $memoryString, $matches);
                $ddrVersion = $matches[0] ?? $memoryString;

                $query->whereHas('specs', function($q) use ($ddrVersion) {
                    $q->where(function($subQuery) {
                        $subQuery->where('spec_key', 'LIKE', '%memory%')
                        ->orWhere('spec_key', 'LIKE', '%ram%')
                        ->orWhere('spec_key', 'LIKE', '%type%');
                    })->where('spec_value', 'LIKE', '%' . $ddrVersion . '%');
                });
            }
        }

        // 3. Motherboard & Case Form Factor Compatibility
        if ($category === 'case' && isset($this->selected['motherboard'])) {
            $formFactor = $this->findSpecValue($this->selected['motherboard']['specs'], ['form', 'factor', 'size']);
            if ($formFactor) {
                $query->whereHas('specs', function($q) use ($formFactor) {
                    $q->where('spec_key', 'LIKE', '%form%')
                    ->where('spec_value', 'LIKE', '%' . $formFactor . '%');
                });
            }
        }

        return $query;
    }

    public function render()
    {
        $categoryProducts = [];

        if ($this->activeCategory) {
            $dbCategoryName = $this->categories[$this->activeCategory]['db_name'];

            $query = Product::where('product_part', $dbCategoryName)->with('specs');
            $query = $this->applyCompatibilityFilters($query, $this->activeCategory);
            $categoryProducts = $query->get();
        }

        return view('livewire.part-picker', ['availableProducts' => $categoryProducts]);
    }
}
