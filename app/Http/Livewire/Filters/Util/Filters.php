<?php

namespace App\Http\Livewire\Filters\Util;

use App\Http\Livewire\Util\AbstractCollection;

class Filters extends AbstractCollection
{
    public function __construct(Filter ...$filters)
    {
        parent::__construct();

        foreach (array(...$filters) as $filter) {
            $this->collection->push($filter);
        }
    }
    public function validateF($f)
    {

        $ranges = $this->collection->filter(function ($item) {
            return $item->type() === 'range';
        });

        foreach ($f as $key => $values) {
            foreach ($values as $keyValue => $value) {
                if ($value == 0 || false) {
                    unset($f[$key][$keyValue]);
                }
            }
            $filter = $this->filter($key);
            if (!$filter) {
                unset($f[$key]);
            }
        }

        foreach ($ranges as $range) {
            $key = $range->key;
            if (isset($f[$key]) && isset($f[$key]['min']) && isset($f[$key]['max'])) {
                foreach ($f[$key] as $keyItem => $item) {
                    if ($item > $range->attributes['max'] || $item < $range->attributes['min']) {
                        $f[$key][$keyItem] = $range->attributes[$keyItem];
                    }
                }
            } else {
                $f[$key] = [
                    'min' => $range->attributes['min'],
                    'max' => $range->attributes['max'],
                ];
            }
        }

        return $f;
    }
    public function filter(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }
}
