<?php

namespace App\Http\Livewire\Filters\Util;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Filter
{
  private $page;
  protected string $view = 'input';
  protected string $type = 'text';

  public function __construct(
    public string $key,
    public string|null $field = null,
    public string|null $title = null,
    public string|null $relatedField = null,
    public array $attributes = [],
    public Closure|null $customQuery = null,
    public bool $multiple = false,
    public array $values = [],
  ) {
    $this->key = $key;
    $this->field = $field ?? $key;
    $this->title = $title ?? $key;

    $this->values = $values;
  }

  public function apply(Builder $query, $value): Builder
  {
    if (!$value) {
      return $query;
    }
    if ($this->customQuery) {
      $query->where($this->customQuery);
    } elseif ($this->relatedField) {
      $query = $query->whereHas($this->field, function (Builder $q) use ($value) {
        return is_array($value)
          ? $q->whereIn($this->relatedField, $value)
          : $q->where($this->relatedField, '=', $value);
      });
    } elseif (is_array($value)) {
      // dd($value);
      $query = $query->whereIn($this->field, $value);
    } else {
      $query = $query->where($this->field, '=', $value);
    }
    return $query;
  }
  public function type()
  {
    return $this->type;
  }
  public function render($page)
  {
    $this->page = $page;

    return view("livewire.filters.$this->view", [
      'filter' => $this,
      'page' => $page,
    ])->render();
  }

  public function __serialize(): array
  {
    unset($this->page);

    return get_object_vars($this);
  }
}
