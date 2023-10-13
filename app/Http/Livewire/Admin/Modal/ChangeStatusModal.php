<?php

namespace App\Http\Livewire\Admin\Modal;

use App\Http\Livewire\Modal\Index;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ChangeStatusModal extends Index
{
    public $model;
    public $statuses;
    public $item;
    public function name(): string
    {
        return 'modal-change-status';
    }
    public function title(): string
    {
        return 'change status';
    }
    public function makeQuery()
    {
        return $this->model::query();
    }
    public function openModal($itemId, $data)
    {
        $this->model = $data['model'] ?  $data['model']  : $this->model;
        $this->statuses = $data['statuses'] ? $data['statuses']::cases() : $this->statuses;
        $this->item = $this->makeQuery()->where('id', $itemId)->first();
        $this->open = true;
    }
    public function update($status)
    {
        $this->open = false;
        $this->item->update([
            'status' => $status,
        ]);
        $this->emit('refresh-table');
        alert()->setData([
            "message" => 'статус успішно змінений',
            'type' => 'success',
            'dellay' => 3003
        ]);
        alert()->open($this);
    }
    public function content(): View
    {
        return view('livewire.admin.modal.change-status-modal', [
            'item' => $this->item,
            'statuses' => $this->statuses,
        ]);
    }
}
