<?php

namespace App\Http\Livewire\Product;

use App\Models\Sku;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    protected $listeners = ['filtersApplied'];
    public $category;
    private $skus = [];
    public function mount()
    {
        $this->skus = Sku::query()->with('values')->whereHas('product', function ($query) {
            $query->where('category_id', $this->category->id);
        })->paginate(15);
    }
    public function filtersApplied($selectedFilters)
    {
        $this->skus = Sku::whereHas('product', function ($query) use ($selectedFilters) {
            $query->where('category_id', $this->category->id);
            if (!empty($selectedFilters['brands'])) {
                $query->whereIn('brand_id', $selectedFilters['brands']);
            }
        })
            ->where(function ($query) use ($selectedFilters) {
                if (!empty($selectedFilters['options'])) {
                    $query->whereHas('values', function ($subQuery) use ($selectedFilters) {
                        $subQuery->whereIn('option_value_id', $selectedFilters['options']);
                    });
                }
                $query->whereBetween('price', [
                    $selectedFilters['price']['min'],
                    $selectedFilters['price']['max'],
                ]);
            })
            ->paginate(20);
    }
    public function render()
    {
        return view('livewire.product.index', [
            'skus' => $this->skus,
        ]);
    }
}
