<?php

namespace App\Http\Livewire\Admin\Order;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Contracts\Database\Query\Builder;
use Livewire\Component;

class Index extends Table
{
    public function title(): string
    {
        return 'Orders';
    }
    public function createdLink()
    {
        return route('admin.orders.index');
    }
    public function model(): string
    {
        return Order::class;
    }
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'status',
                title: 'status',
                view: 'default:fieldEdit',
                columnParams: [
                    'options' => OrderStatusEnum::cases(),
                    'model' => $this->model(),
                ],
            ),
            new Column(
                key: 'amount',
                title: 'amount',
            ),
            new Column(
                key: 'payments',
                sortable: false,
                title: 'payment',
                view: 'admin.order.columns.paymentColumn',
                columnParams: [
                    'model' => Payment::class,
                    'options' => PaymentStatusEnum::cases(),
                    'field' => 'status',
                ],
            ),
            new Column(
                key: 'customer.first_name',
                sortable: false,
                title: 'customer',
                view: 'admin.order.columns.customerColumn',
            ),
            new Column(
                key: 'address.warehouse.address',
                sortable: false,
                view: 'admin.order.columns.addressColumn',
                title: 'address',
            ),
            new Column(
                key: 'created_at',
                title: 'Created',
                view: 'default:date',
            ),
        );
    }
    public function filters(): Filters
    {
        return new Filters(
            new Filter(
                key: 'status',
                values: 'statusValues',
                title: 'status',
                view: 'default:status',
            ),
            new Filter(
                key: 'paymentSystem',
                values: 'paymentSystemValues',
                title: 'payment system',
                view: 'default:status',
            ),
            new Filter(
                key: 'dateFrom',
                title: trans('base.date_start'),
                view: 'default:date',
            ),
            new Filter(
                key: 'dateTo',
                title: trans('base.date_end'),
                view: 'default:date',
            ),
            new Filter(
                key: 'dateFrom',
                title: trans('base.date_start'),
                view: 'default:date',
            ),
            new Filter(
                key: 'dateTo',
                title: trans('base.date_end'),
                view: 'default:date',
            ),
        );
    }
    public function extendQuery(Builder $builder): Builder
    {
        return $builder->with('customer', 'payments', 'address.warehouse.city.area');
    }
    // public function actions(): Actions
    // {
    //     return new Actions(
    //         new Action(
    //             key: 'show',
    //             icon: 'ri-eye-line',
    //             style: 'btn-primary'
    //         )
    //     );
    // }
    // public function actionShow(Order $order)
    // {
    //     return redirect()->route('orders.show', $order->id);
    // }
    public function paymentSystemValues()
    {
        $values = [
            'cash' => 'cash',
        ];

        foreach (PaymentSystemEnum::cases() as $system) {
            $values[$system->value] = $system;
        }
        return $values;
    }
    public function statusValues()
    {
        $values = [];

        foreach (OrderStatusEnum::cases() as $payStatus) {
            $values[$payStatus->value] = $payStatus;
        }

        return $values;
    }
}
