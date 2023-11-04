<?php

namespace App\Http\Livewire\Filters;

use App\Http\Livewire\Filters\Util\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class Range extends Filter
{
    protected string $view = 'range';
    protected string $type = 'range';
    public function apply(Builder $query, $value): Builder
    {
        if (!$value) {
            return $query;
        }
        if (array_key_exists('min', $value) && $value['min'] && array_key_exists('max', $value) && $value['max']) {
            return $query->whereBetween(
                $this->field,
                [
                    $value['min'],
                    $value['max'],
                ]
            );
        }
        if (array_key_exists('min', $value) && $value['min']) {
            return $query->where($this->field, '>', $value['min']);
        }
        if (array_key_exists('max', $value) && $value['max']) {
            return $query->where($this->field, '<', $value['max']);
        }
        return $query;
    }
    public function validate($f)
    {
        $isSame = true;
        if (array_key_exists('min', $f) && array_key_exists('min', $f) && $f['min'] !== $this->attributes['min'] || array_key_exists('max', $f) && $f['max'] !== $this->attributes['max']) {
            $isSame = false;
        }
        return $isSame;
    }
}
