<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentSystemInterface;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use App\SDK\LiqPay;
use App\Services\OrderService;
use Illuminate\Http\Request;

class LiqPayService implements PaymentSystemInterface
{
    private $liqPay;
    public function __construct()
    {
        try {
            $this->liqPay = new LiqPay;
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function createCheckoutUrl(Payment $payment, $route): string|false
    {
        try {

            $url = $this->liqPay->checkout($payment, $route);

            PaymentService::updatePaymentPageUrl($payment, $url);

            return $url;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function getStatus(Payment $payment): PaymentStatusEnum
    {
        try {
            $status = $this->liqPay->getStatus($payment);
            switch ($status->status) {
                case 'reversed':
                case 'failure':
                    return PaymentStatusEnum::Declined;
                case 'success':
                    return PaymentStatusEnum::Successful;
                case 'try_again':
                    return PaymentStatusEnum::Waiting;
                case 'error':
                    if ($status->code === 'payment_not_found' && $payment->payment_expired_time < now()) {
                        return PaymentStatusEnum::Waiting;
                    }
                    return PaymentStatusEnum::Declined;
            }
        } catch (\Throwable $th) {
            return PaymentStatusEnum::Declined;
        }
    }
    public function response(Request $request, Payment $payment)
    {
        $orderService = new OrderService;
        $status = $this->getStatus($payment);
        $payment->update([
            'status' => $status,
        ]);
        $orderService->updateStatus($payment->payable,$status);
    }
}
