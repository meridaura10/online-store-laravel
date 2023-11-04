<?php


namespace App\Http\Livewire\Sorts;

use App\Http\Livewire\Util\AbstractCollection;

class Sorts extends AbstractCollection
{
    public function __construct(Sort ...$sorts)
    {
        parent::__construct();

        foreach (array(...$sorts) as $sort) {
            $this->collection->push($sort);
        }
    }
    public function sort(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }
}
