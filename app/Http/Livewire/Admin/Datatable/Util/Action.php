<?php


namespace App\Http\Livewire\Admin\Datatable\Util;

use App\Http\Livewire\Admin\Datatable\Table;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Action
{
    public function __construct(
        public string $key,
        public string|null $title = null,
        public string|null $icon = null,
        public string|null $method = null,
        public string|null $style = null,
        public string|null $confirm = null,
        public string|null $confirm_title = null,
        public string|null $confirm_description = null,
    ) {
        $this->method = $method ?? Str::camel("action_$this->key");
    }
    public function call(Table $table,Model $row){
        if (method_exists($table,$this->method)) {
            $table->{$this->method}($row);
        } else {
            throw new Exception("Method: $this->method not exists for your table. Create \"$this->method\" method for this action.");
        }
    }
    public function render(Model $row){
        return view('livewire.admin.datatables.defaults.action', [
            'action' => $this,
            'item' => $row,
        ])->render();
    }
}
