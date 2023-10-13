<?php

namespace App\Services;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\OrderStatusEnums;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\PaymentTypeEnums;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payments\FondyService;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderService
{
    private function create($data)
    {
        try {
            DB::beginTransaction();
            $order = Order::create([
                'status' => $data['paymentType'] === PaymentTypeEnum::Cash->value ? OrderStatusEnum::Approved->value : OrderStatusEnum::Processed->value,
                'user_id' => auth()->check() ? auth()->user()->id : null,
                'amount' => basket()->sum(),
            ]);

            foreach (basket()->getItems() as $basketItem) {
                if ($basketItem->sku->quantity >= $basketItem->quantity) {
                    $order->products()->create([
                        'sku_id' => $basketItem->sku_id,
                        'quantity' => $basketItem->quantity,
                        'price' => $basketItem->sku->price,
                        'name' => $basketItem->sku->name,
                    ]);
                    // $basketItem->sku()->decrement('quantity', $basketItem->quantity);
                } else {
                    alert()->setData([
                        'message' =>  'Недостатньо товару на складі',
                        'type' => 'error',
                        'dellay' => 3000
                    ]);
                    throw new \Exception('Недостатньо товару на складі');
                }
            }
            // basket()->delete();

            $order->address()->create($data['orderAddress']);
            $order->customer()->create($data['orderCustomer']);

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function make($data)
    {
        try {
            $order = $this->create($data);
            $paymentService = new PaymentService;
            $payment = $paymentService->createOrderPayment($order, $data['paymentType'], $data['paymentSystem']);
            if ($payment->type === PaymentTypeEnum::Cash->value) {
                return route('orders.show', ['order' => $order->id]);
            }
            return $paymentService->createCheckoutUrl($payment, 'orders');
            
        } catch (\Throwable $th) {
            alert()->setData([
                'message' => 'Сталась помилка при створенні замовлення. Спробуйте пізніше',
                'type' => 'error',
                'dellay' => 4000,
            ]);
            return false;
        }
    }
    public function acceptCheckout(Request $request)
    {
        try {
            $result = new \Cloudipsp\Result\Result($request->all(), 'test');

            $paymentOrder = Payment::query()->where('id', $result->getData()['order_id'])->first();
            $order =  $paymentOrder->payable;
            if ($result->isApproved()) {
                $paymentOrder->update([
                    'status' => PaymentStatusEnum::Successful->value,
                ]);

                $order->update([
                    'status' => OrderStatusEnum::Approved->value,
                ]);
            }
            if ($result->isDeclined() || $result->isExpired()) {
                $paymentOrder->update([
                    'status' => PaymentStatusEnum::Declined->value,
                ]);

                $order->update([
                    'status' => OrderStatusEnum::Declined->value,
                ]);
            }
            return $order;
        } catch (\Throwable $th) {
            return false;
        }
    }
    static public function updateStatus(Order $order,$status){
        switch ($status) {
            case PaymentStatusEnum::Declined:
                $order->update([
                    'status' => OrderStatusEnum::Declined->value,
                ]);
                break;
            case PaymentStatusEnum::Waiting:
                $order->update([
                    'status' => OrderStatusEnum::paymentWaiting->value,
                ]);
                break;
            case PaymentStatusEnum::Successful:
                $order->update([
                    'status' => OrderStatusEnum::Approved->value,
                ]);
                break;
            default:
                break;
        } 
    }
}
