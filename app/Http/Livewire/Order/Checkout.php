<?php

namespace App\Http\Livewire\Order;

use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\PaymentTypeEnums;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderCustomer;
use App\Models\OrderPayment;
use App\Models\Sku;
use App\Models\Warehouse;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Checkout extends Component
{
    public Collection $areas;
    public $area;
    public string $searchArea;

    public Collection $cities;
    public $city;
    public string $searchCity;

    public Collection $warehouses;
    public $warehouse;
    public string $searchWarehouse;
    public Order $order;
    public OrderCustomer $orderCustomer;
    public OrderAddress $orderAddress;
    public $paymentType;
    public $paymentSystem;



    public function mount(Order $order, OrderCustomer $orderCustomer, OrderAddress $orderAddress)
    {
        $this->order = $order;
        $this->orderCustomer = $orderCustomer;
        $this->orderCustomer = $orderCustomer;
        $this->orderAddress = $orderAddress;
        $this->areas = Area::all();
        basket()->checkQuantityOnLoad();
    }

    public function selectCartPaymant()
    {
        if (!$this->paymentSystem) {
            $this->paymentSystem = PaymentSystemEnum::LiqPay->value;
        }
    }
    public function selectCashPayment()
    {
        $this->paymentSystem = PaymentTypeEnum::Cash->value;
    }
    public function updatedSearchArea($value)
    {

        $this->areas = Area::withCities()->search($value)->get();
    }

    public function updatedArea($value)
    {
        $this->cities = City::byArea($this->area['id'])->withWarehouses()->get();

        $this->city = [];
    }

    public function updatedSearchCity($value)
    {

        $this->cities = City::byArea($this->area['id'])->withWarehouses()->search($value)->get();
    }

    public function updatedCity($value)
    {
        $this->warehouses = Warehouse::byCity($value['id'])->get();

        $this->warehouse = [];
    }

    public function updatedSearchWarehouse($value)
    {
        $this->warehouses = Warehouse::byCity($this->city['id'])->search($value)->get();
    }
    public function updatedWarehouse($value)
    {
        $this->orderAddress->warehouse_id = $value['id'];
    }
    public function rules()
    {
        $rules = [];

        $rules['area'] = ['required'];
        $rules['city'] = ['required'];
        $rules['warehouse'] = ['required'];
        $rules['paymentType'] = ['required'];

        $rules['paymentSystem'] = ['required'];

        $rules['orderCustomer.last_name'] = ['required'];
        $rules['orderCustomer.first_name'] = ['required'];
        $rules['orderCustomer.patronymics'] = ['required'];
        $rules['orderCustomer.phone'] = ['required'];
        $rules['orderAddress.warehouse_id'] = ['required'];

        return $rules;
    }
    public function redirectBasket()
    {
        redirect()->route('basket.index');
    }
    public function submit()
    {
        $data = $this->validate();
        $orderService = new OrderService;

        $url = $orderService->make($data);

        if ($url) {
            redirect($url);
        }
        
        alert()->open($this);
    }
    public function render()
    {
        return view('livewire.order.checkout');
    }
}
