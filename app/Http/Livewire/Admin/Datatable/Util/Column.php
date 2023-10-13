<?php

namespace App\Http\Livewire\Admin\Datatable\Util;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class Column
{
    public function __construct(
        public string $key,
        public string|null $title,
        public string|null $view = null,
        public bool|null $sortable = true,
        public string|null $sortScope = 'orderBy',
        public array|null $columnParams = null,
    ) {
        $this->title = $title ?? $key;

        $this->view($view);
    }

    public function view(string $view = null)
    {
        if ($view) {
            if (Str::startsWith($view, 'default:')) {
                $this->view = "livewire.admin.datatables.defaults.columns." . Str::after($view, 'default:');
            } else {
                $this->view = $view;
            }
        } else {
            $this->view = 'livewire.admin.datatables.defaults.column';
        }
        return $this;
    }
    public function value(Model $item)
    {
        $relations = explode('.', $this->key);
        $value = $item;

        foreach ($relations as $relation) {
            switch (true) {
                case $value instanceof Model:
                    $value = $value->{$relation};
                    break;
                case $value instanceof Collection:
                    $value = $value->pluck($relation);
                    break;
            }
        };
        return $value;
    }
    public function valueIsArray(Model $item)
    {
        $value = $this->value($item);

        switch (true) {
            case $value instanceof Collection:
                return true;

            case $value instanceof SupportCollection:
                return true;
        }

        return false;
    }

    public function sortable(bool $sort = true,string $sortScope = null){
        $this->sortable = $sort;
        $this->sortScope = $sortScope ?? 'orderBy';

        return $this;
    }
    public function render(Model $item)
    {
        return view($this->view, [
            'item' => $item,
            'column' => $this,
        ])->render();
    }
}
