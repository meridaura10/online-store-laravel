<?php


namespace App\Http\Livewire\Sorts;

use Closure;
use Illuminate\Contracts\Database\Query\Builder;

class Sort
{
    private $page;
    public function __construct(
        public string $key,
        public string|null $field = null,
        public string|null $title = null,
        public string|null $relatedField = null,
        public string|null $direction = 'asc',
        public string|null $scope = null
    ) {
        $this->key = $key;
        $this->field = $field ?? $key;
        $this->title = $title ?? $key;
    }

    public function apply(Builder $query): Builder
    {
        if ($this->scope) {
            return $query->{$this->scope}($this->direction);
        }
        return $query->orderBy($this->field, $this->direction);
    }
    public function render($page)
    {
      $this->page = $page;
  
      return view("livewire.sorts.option", [
        'sort' => $this,
        'page' => $page,
      ])->render();
    }
    public function __serialize(): array
    {
      unset($this->page);
  
      return get_object_vars($this);
    }
}
