<?php

namespace App\Http\Livewire\Filters;

use App\Http\Livewire\Filters\Util\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class CategoryFilter extends Filter
{
    protected string $view = 'category-filter';
    protected string $type = 'categories';

    public function apply(Builder $query, $value): Builder
    {
        if (!$value) {
            return $query;
        }


        $categoryIds = $this->values[$value[key($value)]];

        $categoryIds = array_map(function ($value) {
            return key($value['category']);
        }, $categoryIds);

        return $query->whereHas($this->field, function ($q) use ($categoryIds) {
            return $q->whereIn('category_id', $categoryIds);
        });
    }
}
