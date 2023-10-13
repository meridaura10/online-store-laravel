<?php

namespace App\Http\Livewire\Header;

use Livewire\Component;

class Basket extends Component
{
    public $quantity = 0;
    protected $listeners = ['updateQuantity' => 'update'];
    public function mount(){
        $this->update();
    }
    public function update(){
        $this->quantity = basket()->quantity();
    }
    public function render()
    {
        return view('livewire.header.basket');
    }
}
