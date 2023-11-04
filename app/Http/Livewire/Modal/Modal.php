<?php

namespace App\Http\Livewire\Modal;

use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class Modal extends Component
{
    public $open = false;
    abstract public function name(): string;
    abstract public function title(): string;
    abstract public function content(): View;
    protected function getListeners()
    {
        return [
            $this->name().'-open' => 'openModal',
        ];
    }
    public function open()
    {
        $this->open = true;
    }
    public function hidden()
    {
        $this->open = false;
    }
    public function render()
    {
        return view('livewire.modal.index');
    }
}
