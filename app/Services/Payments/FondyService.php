<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentSystemInterface;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\Fondy\FondyStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Order;
use App\Models\Payment;
use Cloudipsp\Checkout;
use Cloudipsp\Configuration;
use Illuminate\Http\Request;

class FondyService implements PaymentSystemInterface
{
    public function __construct()
    {
        Configuration::setMerchantId(1396424);
        Configuration::setSecretKey('test');
    }
    public function createCheckoutUrl(Payment $payment, $route): string|false
    {
        try {
            $data = [
                'order_desc' => 'tests SDK',
                'currency' => 'UAH',
                'order_id' => $payment->id,
                'amount' => intval($payment->amount * 100),
                'response_url' => route("$route.payment.response", ['payment' => $payment->id]),
                'server_callback_url' => route("$route.payment.callback", ['payment' => $payment->id]),
                'lang' => 'ua',
                'lifetime' => 36000,
            ];

            $url = Checkout::url($data)->getUrl();

            PaymentService::updatePaymentPageUrl($payment,$url);

            return $url;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }
    public function getStatus(Payment $payment): PaymentStatusEnum
    {
        $orderStatus = \Cloudipsp\Order::status([
            'order_id' => $payment->id,
        ]);

        switch ($orderStatus->getData()['order_status']) {
            case FondyStatusEnum::Created->value:
                return PaymentStatusEnum::Waiting;

            case FondyStatusEnum::Processing->value:
                return PaymentStatusEnum::Waiting;

            case FondyStatusEnum::Approved->value:
                return PaymentStatusEnum::Successful;

            case FondyStatusEnum::Declined->value:
                return PaymentStatusEnum::Declined;

            case FondyStatusEnum::Reversed->value:
                return PaymentStatusEnum::Declined;

            case FondyStatusEnum::Expired->value:
                return PaymentStatusEnum::Declined;

            default:
                return PaymentStatusEnum::Waiting;
        }
    }
}
