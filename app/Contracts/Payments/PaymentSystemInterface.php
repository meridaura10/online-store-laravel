<?php

namespace App\Contracts\Payments;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

interface PaymentSystemInterface{
   public function createCheckoutUrl(Payment $payment,$route):string|false;
   public function response(Request $request, Payment $payment);
   public function getStatus(Payment $payment): PaymentStatusEnum|false;
}