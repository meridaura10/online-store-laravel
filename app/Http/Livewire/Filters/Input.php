<?php

namespace App\Http\Livewire\Filters;

use App\Http\Livewire\Filters\Util\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class Input extends Filter
{
    public function apply(Builder $query,$value): Builder{
        return $query->whereTranslationLike('name', "%$value%");
    }
}
