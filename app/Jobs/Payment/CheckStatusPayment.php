<?php

namespace App\Jobs\Payment;

use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\Payments\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStatusPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(PaymentService $paymentService): void
    {
        $payments = Payment::where('type', PaymentTypeEnum::Card->value)
            ->where('status', PaymentStatusEnum::Waiting->value)
            ->with('payable')
            ->get();

        foreach ($payments as $payment) {
            if (!$payment instanceof Model) {
                return;
            }

            $service = $paymentService->getServiceToSystemPayment($payment->system);
            $status = $service->getStatus($payment);
            $payment->update([
                'status' => $status->value,
            ]);
            if ($payment->payable instanceof Order) {
                OrderService::updateStatus($payment->payable, $status);
            }
        }
    } 
    
}
