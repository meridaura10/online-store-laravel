<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Option;
use App\Models\Product;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Support\Str;

class BasketService
{
    public $basket;
    public $token;
    public function __construct()
    {
        if (!auth()->check()) {
            $this->setBasketToken();
        }
        $this->basket = $this->getBasket();
    }
    private function setBasketToken()
    {
        $this->token = session('basketToken');

        if (!$this->token) {
            session()->put('basketToken', Str::uuid()->toString());
            $this->token = session('basketToken');
        }
    }
    public function getBasket()
    {
        if ($this->basket) {
            return $this->basket;
        }
        if (auth()->check()) {
            $this->basket = auth()->user()->basket;
        }

        if (!$this->basket) {
            $this->basket = Basket::query()->where('session_id',$this->token)->first();
        }

        if (!$this->basket) {
            $this->basket = $this->createBasket();
        }

        return $this->basket;
    }
    public function isEmpty(){
        return $this->getItems()->isEmpty();
    }
    public function checkQuantityOnLoad()
    {
        $items = basket()->getItems();
        $changesMade = false; // Змінна для відстеження, чи були внесені зміни
    
        foreach ($items as $item) {
            if ($item->quantity > $item->sku->quantity) {
                $item->quantity = $item->sku->quantity;
                $changesMade = true; // Внесено зміни
            }
        }
    
        if ($changesMade) {
            session()->flash('success', 'Деякі товари були видалені або змінено кількість у вашому кошику.');
        }
    }   
    private function createBasket()
    {
        if (auth()->check()) {
            return auth()->user()->basket()->create();
        }

        return Basket::create([
            'session_id' => $this->token,
            'lifetime' => now(),
        ]);
    }
    public function getItems()
    {
        return $this->getBasket()->basketItems;
    }
    public function getItem($skuId)
    {
        return $this->getItems()->where('sku_id', $skuId)->first();
    }
    public function createItem(Sku $sku)
    {
        $basketItem = $this->getBasket()->basketItems()->where('sku_id',$sku->id)->first();
        if (!$basketItem && $sku->quantity) {
            $this->getBasket()->basketItems()->create([
                'sku_id' => $sku->id,
            ]);
        }
        $this->updateLifetime();
    }
    public function removeItem(BasketItem $basketItem)
    {
        $basketItem->delete();

        $this->updateLifetime();
    }
    public function updateItem(BasketItem $basketItem, $quantity)
    {
        if ($basketItem->sku->quantity >= $quantity) {
            $basketItem->update([
                'quantity' => $quantity,
            ]);
        }
        $this->updateLifetime();
    }
    private function updateLifetime()
    {
        if (!auth()->check()) {
            if ($this->basket->lifetime->lt(now()->subMinutes(5))) {
                $this->basket->update(['lifetime' => now()]);
            }
        }
    }
    public function sum()
    {
        return $this->getItems()->sum('sum');
    }
    public function quantity()
    {
        return $this->getItems()->sum('quantity');
    }
    public function clearOld(){
        Basket::where('lifetime', '<', now()->subDays(7))->delete();
    }
    public function updateToUser(User $user){
       Basket::query()->where('session_id',$this->token)->first()->update([
            'user_id' => $user->id,
            'lifetime' => null,
        ]);
    }
    public function delete(){
        $this->getBasket()->delete();
    }
}
