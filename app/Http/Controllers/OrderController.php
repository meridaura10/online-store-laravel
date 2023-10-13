<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\Payments\FondyService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('order.checkout');
    }
    public function show(Order $order)
    {
        dd('show', $order);
    }
    public function response(Request $request, OrderService $service)
    {
        $order = $service->acceptCheckout($request);
        if ($order) {
            return redirect()->route('orders.show', compact('order'));
        }
        alert()->setData([
            'type' => 'error',
            'message' => 'сталась помилка при повернені на сайт після оплати',
            'dellay' => 4000,
        ]);
    }
    public function callback(Request $request,OrderService $service)
    {
        $order = $service->acceptCheckout($request);
        if ($order) {
            return response(200);
        }
    }
}
