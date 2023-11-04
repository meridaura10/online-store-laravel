<?php

namespace App\Http\Livewire\Header;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Collection;
use Livewire\Component;

class Search extends Component
{
    public string $value = '';

    public bool $open = false;
    public Collection $skus;
    public Collection $categories;
    public function mount()
    {
        $this->skus = collect();
        $this->categories = collect();
    }
    public function updatedValue($value)
    {
        $this->skus = $value ? $this->getSkus($value) : collect();
        $this->categories =  $value ? $this->getCategories($value) : collect();
        $this->open();
    }
    public function getSkus($value)
    {
        $arrayValue = explode(' ', $value);

        $query = Sku::query()
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->whereHas('product', function ($q) {
                $q->where("status", 1);
            })
            ->limit(6)
            ->with('product.translations','values.translations','bannerImage');

        foreach ($arrayValue as $value) {
            $query = $query->where(function ($subquery) use ($value) {

                $subquery->orWhere(function ($orSubquery) use ($value) {
                    $orSubquery->whereHas('product', function ($q) use ($value) {
                        $q->search($value);
                    })->orWhereHas('values', function ($q) use ($value) {
                        $q->search($value);
                    });
                });
            });
        }

        return $query->get();
    }
    public function getCategories($value)
    {
        return Category::query()
            ->where('status', 1)
            ->search($value)
            ->limit(3)
            ->with('translations','image')
            ->get();
    }
    public function hidden(){
        $this->open = false;
    }
    public function open(){
        if ($this->skus->count() || $this->categories->count()) {
            $this->open = true;
        }else{
            $this->open = false;
        }
    }
    public function render()
    {
        return view(
            'livewire.header.search',
        );
    }
}
