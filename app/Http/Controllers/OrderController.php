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
    public function response(Request $request,Payment $payment, OrderService $service)
    {
        $payment = $service->acceptCheckout($request,$payment);
        if ($payment) {
            return redirect()->route('cabinet.orders');
        }
        alert()->setData([
            'type' => 'error',
            'message' => 'сталась помилка при повернені на сайт після оплати',
            'dellay' => 4000,
        ]);

        return redirect()->route('home.index');
    }
    public function callback(Request $request,Payment $payment,OrderService $service)
    {
        $payment = $service->acceptCheckout($request,$payment);
        if ($payment) {
            return response(200);
        }
    }
}
