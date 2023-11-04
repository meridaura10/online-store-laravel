<?php

namespace App\Http\Livewire\Components;

use App\Http\Livewire\Filters\Util\Filters;
use App\Http\Livewire\Sorts\Sort;
use App\Http\Livewire\Sorts\Sorts;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

abstract class ProductList extends Component
{
    use WithPagination;
    public Filters $filters;
    public Sorts $sorts;
    public $f = [];
    public $sort;
    protected $queryString = ['f', 'sort'];

    abstract public function makeQuery(): Builder;

    abstract public function filters(): Filters;

    abstract public function contentHeader(): View;

    public function init()
    {
        $this->filters = $this->filters();
        $this->sorts = $this->sorts();
        $this->f = $this->filters->validateF($this->f);
    }
    public function paginationView()
    {
        return 'ui.components.pagination';
    }

    public function items()
    {
        return $this->makeQuery()
            ->filtered($this->filters, $this->f)
            ->sorting($this->sorts, $this->sort)
            ->groupBy('skus.product_id')
            ->with('product.translations', 'values.translations', 'bannerImage', 'reviews')
            ->paginate(50);
    }

    public function sorts(): Sorts
    {
        return new Sorts(
            new Sort(
                key: 'rank',
                field: 'averageRating',
                direction: 'desc',
                title: 'за рейтингом',
                scope: 'sortByRating',
            ),
            new Sort(
                key: 'cheap',
                field: 'price',
                title: 'від дешевих до дорогих',
            ),
            new Sort(
                key: 'expensive',
                field: 'price',
                direction: 'desc',
                title: 'від дорогих до дешевих',
            ),
            new Sort(
                key: 'novelty',
                field: 'created_at',
                direction: 'desc',
                title: 'новинки',
            ),
        );
    }

    public function updatedF()
    {
        $this->f = $this->filters->validateF($this->f);
    }

    public function clearF($filterKey, $valueFilerKey = null)
    {
        if ($valueFilerKey) {
            unset($this->f[$filterKey][$valueFilerKey]);
        } else {
            unset($this->f[$filterKey]);
        }
    }

    public function fullClaerF()
    {
        $this->f = [];
    }

    public function hasFilter()
    {
        $filtered = array_filter(array_keys($this->f), function ($key) {
            $filter = $this->filters->filter($key);
            if ($filter && $filter->type() === 'range') {
                return !$filter->validate($this->f[$key]);
            }
            return count($this->f[$key]) > 0;
        });

        return count($filtered);
    }

    public function render()
    {
        return view('livewire.components.product-list', [
            'skus' => $this->items(),
        ]);
    }
}
