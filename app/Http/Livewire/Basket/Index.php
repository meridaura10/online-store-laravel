<?php

namespace App\Http\Livewire\Basket;

use App\Enums\Order\OrderStatusEnum;
use App\Http\Livewire\Header\Basket;
use App\Http\Livewire\Util\Alert;
use App\Models\BasketItem;
use App\Models\Sku;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        basket()->checkQuantityOnLoad();
        $this->emit('updateQuantity')->to(Basket::class);
    }
    public function update(BasketItem $basketItem, $quantity)
    {
        basket()->updateItem($basketItem, $quantity);
        $this->emit('updateQuantity')->to(Basket::class);
    }
    public function removeProduct(BasketItem $basketItem)
    {
        basket()->removeItem($basketItem);
        $this->emit('updateQuantity')->to(Basket::class);
    }
    public function alert()
    {
        alert()->open($this);
    }
    public function render()
    {
        return view('livewire.basket.index');
    }
}
