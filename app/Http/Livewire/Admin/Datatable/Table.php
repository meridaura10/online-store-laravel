<?php

namespace App\Http\Livewire\Admin\Datatable;

use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

abstract class Table extends Component
{
    use WithPagination;
    public string|null $title;
    public Columns $columns;
    public Filters $filters;
    public Actions $actions;
    public bool $usePagination = true;
    public $perPage = 15;
    public array $perPages = [5, 10,15, 25, 50,100];
    public $sortKey = null;
    public $sortDirection = false;
    public array $f = [];
    abstract public function columns(): Columns;
    public function actions(): Actions
    {
        return new Actions();
    }
    public function filters(): Filters
    {
        return new Filters();
    }
    abstract public function model(): string;
    abstract public function title(): string|null;
    abstract public function extendQuery(Builder $builder);
    abstract public function createdLink();

    public function mount()
    {
        $this->initTable();
    }
    private function initTable()
    {
        $this->columns = $this->columns();
        $this->actions = $this->actions();
        $this->filters = $this->filters();
    }

    public function paginationView()
    {
        return 'livewire.admin.datatables.defaults.pagination';
    }
    public function getTitle(): string
    {
        return $this->title() ?? 'Title';
    }
    public function hasActions(): bool
    {
        return $this->actions->count() > 0;
    }
    private function makeQuery(): Builder
    {
        return $this->model()::query();
    }
    public function actionConfirmed($key, $id)
    {
        $action = $this->actions->action($key);
        $model = $this->makeQuery()->find($id);

        $action->call($this, $model);
    }
    public function action($key, $id)
    {
        $action = $this->actions->action($key);
        if ($action->confirm) {
            $this->emit('confirm-open', $action->confirm_title, $action->confirm_description, 'datatable-action-confirm', [$key, $id]);
        } else {
            $this->actionConfirmed($key, $id);
        }
    }
    protected function getListeners()
    {
        $listeners = $this->listeners;

        return array_merge($listeners, [
            'datatable-action-confirm' => 'actionListener',
            'refresh-table' => '$refresh',
        ]);
    }
    public function actionListener(array $data = null)
    {
        [$key, $id] = $data;
        $action = $this->actions->action($key);
        if ($action) {
            $this->actionConfirmed($key, $id);
        }
    }
    public function setSort(string $column = null, bool $direction = true)
    {
        $this->sortKey = $column;
        $this->sortDirection = $direction;
    }
    public function sortByNext(string $column)
    {
        if ($this->sortKey == $column) {
            if ($this->sortDirection) {
                $this->setSort($column, false);
            } else {
                $this->setSort();
            }
        } else {
            $this->setSort($column);
        }
    }
    public function sortQuery(Builder $builder)
    {
        if ($this->sortKey) {
            $column = $this->columns()->column($this->sortKey);
            $builder->{$column->sortScope}($this->sortKey, $this->sortDirection ? 'asc' : 'desc');
        }
    }
    public function hasFilters(): bool
    {
        return $this->filters()->count() > 0;
    }
    public function getFilterValue(string $key)
    {
        return $this->f[$key] ?? null;
    }
    public function filterQuery(Builder $builder)
    {
        if (count($this->f)) {
            foreach ($this->f as $key => $value) {
                if (!empty($value)) {
                    $filter = $this->filters->filter($key);

                    $builder->{$filter->scope}($value);
                }
            }
        }
    }
    public function hasFilter()
    {
        return count($this->f) > 0 ? count(array_filter(array_values($this->f), function ($i) {
            $isArray = is_array($i);
            if ($isArray) {
                $index = array_search('all', $i);
                return $index === false;
            } else {
                return !empty($i);
            }
        })) : false;
    }

    public function clearFilter()
    {
        $this->f = [];
        $this->setPage(1);
    }


    public function resultQuery(Builder $builder)
    {
        if ($this->usePagination) {
            $paginateItems = $builder->paginate($this->perPage);
            if ($paginateItems->isEmpty()) {
                $this->resetPage();
                 return $builder->paginate($this->perPage);
            }else{
                return $paginateItems;
            }
        }
        return $builder->limit(30)->get();
    }
    public function hasAddLink():bool{
        return $this->title() ? true : false;
    }
    private function items()
    {
        $bailder = $this->makeQuery();
        $this->extendQuery($bailder);
        $this->filterQuery($bailder);
        $this->sortQuery($bailder);
        return $this->resultQuery($bailder);
    }
    public function switchChange($key, $id)
    {
        $method = Str::camel("switch_$key");
        if (method_exists($this, $method)) {
            $model = $this->makeQuery()->find($id);
            $this->{$method}($model);
        } else {
            throw new Exception("Method: $method not exists for your table. Create \"$method\" method for switch status.");
        }
    }
    public function render(): View
    {
        return view('livewire.admin.datatables.table', [
            'items' => $this->items(),
        ]);
    }
}
