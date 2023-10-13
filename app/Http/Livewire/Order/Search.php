<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class Search extends Component
{
    public $phone;
    public $code;
    public $openModal = false;
    public $phoneVerify = 'none';
    public $orders;
    public function rules()
    {
        return [
            'phone' => ['required'],
        ];
    }
    protected $listeners = ['open-modal-orders-serach' => 'openModalOrdersSearch'];
    public function submit()
    {
        $data = $this->validate();
        $this->phoneVerify = 'processed';
        $this->emit('orders-get-phone',[
            'phone' => $data['phone'],
        ]);
    }
    public function openModalOrdersSearch(){
        $this->openModal = true;
    }
    public function editPhone(){
        $this->phoneVerify = 'none';
    }
    public function updatedCode($value){
        if (strlen($value) === 4) {
            
            $this->orders = Order::query()->whereHas('customer',function($query){
              return $query->where('phone',trim($this->phone));
            })->get();

            $this->openModal = false;
        }
    }
    public function hiddenModal()
    {
        $this->openModal = false;
    }
    public function render()
    {
        return view('livewire.order.search');
    }
}
