<?php

namespace App\Services\Payments;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\OrderStatusEnums;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\PaymentTypeEnums;
use App\Models\Order;

use App\Models\OrderPayment;
use App\Models\Payment;

class PaymentService
{
    public function createCheckoutUrl(Payment $payment, $route): string|false
    {
        $service = $this->getServiceToSystemPayment($payment->system);

        if (!$service) {
            return false;
        }
        return $service->createCheckoutUrl($payment, $route);
    }
    public function createOrderPayment(Order $order, $type, $system): Payment
    {
        try {
            return  $order->payments()->create([
                "currency" => 'UAH',
                "amount" => $order->amount,
                'status' => PaymentStatusEnum::Waiting->value,
                "type" => $type,
                'payment_expired_time' => now()->addHour(),
                'payment_page_url' => null,
                "system" => $system,
            ]);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function getServiceToSystemPayment(string $system)
    {
        switch ($system) {
            case PaymentSystemEnum::LiqPay->value:
                return new LiqPayService;
            case PaymentSystemEnum::Fondy->value:
                return new FondyService;
            default:
                return false;
        }
    }
    static public function updatePaymentPageUrl(Payment $payment, $url)
    {
        $payment->update([
            'payment_page_url' => $url,
        ]);
    }
}
