<?php

namespace App\Http\Livewire\Admin\Datatable\Util;
use App\Http\Livewire\Admin\Datatable\Util\AbstractCollection;
use App\Http\Livewire\Admin\Datatable\Util\Filter;

class Filters extends AbstractCollection{
    public function __construct(Filter ... $filters){
        parent::__construct();

        foreach(array(...$filters) as $filter){
            $this->collection->push($filter);
        }
    }
    public function filter(string $key){
        return $this->collection->where('key',$key)->first();
    }
}