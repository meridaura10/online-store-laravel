<?php

namespace App\Http\Livewire\Admin\Datatable\Util;

use Iterator;
use Livewire\Wireable;

abstract class AbstractCollection implements Wireable, Iterator
{
    private int $position = 0;

    protected $collection;

    public function __construct()
    {
        $this->collection = collect();
    }
    public function count(): int
    {
        return $this->collection->count();
    }
    public function toLivewire()
    {
        try {
            return serialize($this);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public static function fromLivewire($value)
    {
        return unserialize($value);
    }
    public function current(): mixed
    {
        return $this->collection[$this->position];
    }
    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->collection->count() > $this->position;
    }
}
