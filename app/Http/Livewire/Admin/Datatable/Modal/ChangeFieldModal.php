<?php

namespace App\Http\Livewire\Admin\Datatable\Modal;

use App\Http\Livewire\Modal\Modal;
use Illuminate\Contracts\View\View;


class ChangeFieldModal extends Modal
{
    public $model;
    public $field;
    public $options;
    public $item;
    public function name(): string
    {
        return 'modal-change-field';
    }
    public function title(): string
    {
        return "change $this->field";
    }
    public function makeQuery()
    {
        return $this->model::query();
    }
    public function openModal($itemId, $data,$field)
    {
        $this->field = array_key_exists('field',$data) ? $data['field'] : $field;
        $this->model = $data['model'];
        $this->options = $data['options'];
        $this->item = $this->makeQuery()->where('id', $itemId)->first();
        $this->open = true;
    }
    public function update($status)
    {
        $this->open = false;
        $this->item->update([
            "$this->field" => $status,
        ]);
        $this->emit('refresh-table');
        alert()->setData([
            "message" => "$this->field успішно змінений",
            'type' => 'success',
            'dellay' => 3003
        ]);
        alert()->open($this);
    }
    public function content(): View
    {
        return view('livewire.admin.datatables.modal.change-field-modal', [
            'item' => $this->item,
            'options' => $this->options,
        ]);
    }
}
