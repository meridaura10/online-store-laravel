<?php

namespace App\Http\Livewire\Cabinet\Order;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{
    public ?string $sortScope = null;
    public bool $hasOrders = false;
    public bool $sortDirection = true;
    public ?string $sortKey = null;
    public $filters = [];

    public function pay(Payment $payment)
    {
        if (!$payment->payment_page_url) {
            alert()->setData([
                'message' => 'Сталася помилка при перенаправленні на сторінку оплати',
                'type' => 'error',
                'dellay' => 3000,
            ]);
            alert()->open($this);
            return;
        }
        return redirect($payment->payment_page_url);
    }
    public function mount(){
        $this->hasOrders = auth()->check() ? !!auth()->user()->orders()->count() : false;
    }

    public function makeQuery(): Builder
    {
        return auth()->user()->orders();
    }

    public function setSortParams(?string $scope, string $sortKey)
    {
        $this->sortScope = $scope ?? 'orderBy';

        if ($this->sortKey === $sortKey) {
            $this->setSort($sortKey, !$this->sortDirection);
        } else {
            $this->setSort($sortKey);
        }
    }
    public function setFilterParams(string $scope, string $value)
    {
        $this->filters[$scope] = $value;
    }

    public function setSort(string $sortKey, bool $direction = true)
    {
        $this->sortKey = $sortKey;
        $this->sortDirection = $direction;
    }

    public function items(): Collection
    {
        $builder = $this->makeQuery();
        $this->sortQuery($builder);
        $this->filterQuery($builder);
        return $builder->get();
    }
    public function filterQuery(Builder $builder)
    {
        if (count($this->filters)) {
            foreach ($this->filters as $key => $value) {
                return $builder->{$key}($value);
            }
        }
        return $builder;
    }
    public function hasFilter()
    {
        return count($this->filters) > 0 ? count(array_filter(array_values($this->filters), function ($i) {
                return !empty($i);
        })) : false;
    }
    public function clearFilter(){
        $this->filters = [];
    }

    public function sortQuery(Builder $builder)
    {
        if ($this->sortKey) {
            $builder->{$this->sortScope}($this->sortKey, $this->sortDirection ? 'asc' : 'desc');
        }
        $builder;
    }

    public function render()
    {
        return view('livewire.cabinet.order.index', [
            'orders' => $this->items(),
        ]);
    }
}
