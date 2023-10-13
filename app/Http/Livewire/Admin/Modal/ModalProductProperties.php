<?php

namespace App\Http\Livewire\Admin\Modal;

use App\Http\Livewire\Modal\Index;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ModalProductProperties extends Index
{
    public function name(): string
    {
        return 'modal-product-properties';
    }
    public function content(): View
    {
        return view('livewire.admin.modal.modal-product-properties');
    }
    public function openModal(){
        $this->open();
    }
    public function title(): string
    {
        return 'product properties';
    }
}
