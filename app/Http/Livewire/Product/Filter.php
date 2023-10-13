<?php

namespace App\Http\Livewire\Product;

use App\Models\Brand;
use App\Models\OptionValue;
use Livewire\Component;

class Filter extends Component
{
    public $options;
    public $category;
    public $brands;
    public $selectedFilters = [
      'brands' => [],
      'options' => [],
      'price' => [
        'min' => 1 ,
        'max' => 100000000000,
      ],
    ];
    public function mount()
    {
        $options = OptionValue::whereHas('skus', function ($query) {
            $query->where('quantity', '>', 0)->whereHas('product', function ($query) {
                $query->where('category_id', $this->category->id);
            });
        })->get();
        $this->options = $options->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });
        $this->brands = Brand::whereHas('products', function ($query) {
            $query->where('category_id', $this->category->id)
                ->whereHas('skus', function ($query) {
                    $query->where('quantity', '>', 0);
                });
        })->get();
    }
    public function applyFilters() {
        $this->emit('filtersApplied', $this->selectedFilters);
    }
    public function render()
    {
      
        return view('livewire.product.filter');
    }
}
