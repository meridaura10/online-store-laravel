<?php

namespace App\Http\Livewire\Admin\Form;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

abstract class Gallery extends Component
{
    public $item;
    public Collection $images;
    abstract public function model(): string;

    private function makeQuery(): Builder
    {
        return $this->model()::query();
    }
    protected function relationName(): string{
        return 'images';
    }
    public function mount($id)
    {
        $this->item = $this->makeQuery()->where('id', $id)->firstOrFail();
        $this->images = $this->item->{$this->relationName()};
    }
    public function render()
    {
        return view('livewire.admin.form.gallery');
    }
}
