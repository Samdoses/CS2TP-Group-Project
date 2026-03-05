<?php

namespace App\Livewire;

use Livewire\Component;

class PartPicker extends Component
{
    public array $categories = [
        'cpu' => 'CPU',
        'motherboard' => 'Motherboard',
        'ram' => 'Memory (RAM)',
        'gpu' => 'Graphics Card',
        'storage' => 'Storage',
        'psu' => 'Power Supply',
        'case' => 'Case',
    ];

    public array $selected = [];

    public function selectPart($category)
    {
                $this->selected[$category] = [
            'name' => $this->categories[$category],
            'price' => 0,
        ];
    }

    public function removePart($category)
    {
        unset($this->selected[$category]);
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->selected, 'price'));
    }

    public function render()
    {
        return view('livewire.part-picker');
    }
}
