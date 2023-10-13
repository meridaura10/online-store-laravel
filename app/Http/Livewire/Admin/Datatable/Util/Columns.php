<?php

namespace App\Http\Livewire\Admin\Datatable\Util;

use App\Http\Livewire\Admin\Datatable\Util\AbstractCollection;

class Columns extends AbstractCollection {
    public function __construct(Column ... $columns){
        parent::__construct();

        foreach(array(... $columns) as $column){
            $this->collection->push($column);
        };
    }
    public function column(string $key){
        return $this->collection->where('key',$key)->first();
    }
}