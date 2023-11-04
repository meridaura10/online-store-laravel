<?php

namespace App\Contracts\Filters;

use App\Http\Livewire\Filters\Util\Filters;

interface ProductFiltersToModel{
    public function get(): Filters;
}