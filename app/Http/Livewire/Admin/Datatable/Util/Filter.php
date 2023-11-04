<?php

namespace App\Http\Livewire\Admin\Datatable\Util;

use App\Http\Livewire\Admin\Datatable\Table;
use Exception;
use Illuminate\Support\Str;

class Filter
{
    protected $table;
    public function __construct(
        public string $key,
        public string|null $scope = null,
        public string|null $title = null,
        public string|null $view  = null,
        public mixed $values = null,
        public string|null $valuesKey = null,
        public string|null $valuesName = null,
        public bool $multiple = false,
    ) {
        $this->scope = $scope ?? $key;
        $this->view($view);
    }
    public function view(string $view = null)
    {
        if ($view) {
            if (Str::startsWith($view, 'default:')) {
                $this->view = "livewire.admin.datatables.defaults.filters." . Str::after($view, 'default:');
            } else {
                $this->view = $view;
            }
        } else {
            $this->view = 'livewire.admin.datatables.defaults.filters.text';
        }

        return $this;
    }
    public function hasValues()
    {
        return $this->values !== null;
    }

    public function values()
    {
        if ($this->hasValues()) {
            switch (true) {

                case is_string($this->values):
                    if (method_exists($this->table, $this->values)) {
                        $values = $this->table->{$this->values}();
                    } else {
                        throw new Exception("Method: $this->values not exists for your table. Create \"$this->values\" method to get filter values.");
                    }
                    return $values;

                default:
                    return $this->values;
            }
        }
        return [];
    }
    public function render($table)
    {
        $this->table = $table;
        return view($this->view, [
            'filter' => $this,
        ])->render();
    }

    public function __serialize(): array
    {

        unset($this->table);

        return get_object_vars($this);
    }

}
