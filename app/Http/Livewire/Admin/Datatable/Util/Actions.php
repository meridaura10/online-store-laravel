<?php

namespace App\Http\Livewire\Admin\Datatable\Util;

use App\Http\Livewire\Util\AbstractCollection;

class Actions extends AbstractCollection {
    public function __construct(Action ... $actions){
        parent::__construct();

        foreach (array(...$actions) as $action) {
            $this->collection->push($action);
        }
    }

    public function action(string $key){
      return  $this->collection->where('key',$key)->first();
    }
}