<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Admin\Order\Index as OrderIndex;
use App\Models\Order;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends OrderIndex
{
    public $phone;
    protected function getListeners()
    {
        $listeners = $this->listeners;

        return array_merge($listeners, [
            'datatable-action-confirm' => 'actionListener',
            'refresh-table' => '$refresh',
            'orders-get-phone' => 'setPhone',
        ]);
    }
    public bool $usePagination = false;
    public function title(): string
    {
        return 'Мої замовлення';
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function extendQuery(Builder $builder): Builder
    {
        $user = Auth::user(); // Отримуємо поточного користувача, якщо він авторизований.
        if ($user) {
            // Якщо користувач авторизований, відбираємо всі його замовлення.
            $userOrders = $user->orders->pluck('id')->toArray();

            $builder->whereIn('id', $userOrders);

            // Також додаємо умову по номеру телефону, якщо він є.
            if ($this->phone) {
                $phoneOrders = Order::whereHas('customer', function ($query) {
                    return $query->where('phone', $this->phone);
                })->pluck('id')->toArray();

                $builder->orWhereIn('id', $phoneOrders);
            }
        } else {
            $phoneOrders = Order::whereHas('customer', function ($query) {
                return $query->where('phone', $this->phone);
            })->pluck('id')->toArray();
            $builder->whereIn('id', $phoneOrders);
        }
        // Повертаємо об'єкт Builder, на якому можна викликати додаткові методи.
        return $builder;
    }
}
