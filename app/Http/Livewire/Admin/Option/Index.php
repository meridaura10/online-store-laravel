<?php

namespace App\Http\Livewire\Admin\Option;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\Option;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Table
{
    public function model(): string
    {
        return Option::class;
    }
    public function title(): string
    {
        return 'options';
    }
    public function createdLink()
    {
        return route('admin.options.create');
    }
    public function extendQuery(Builder $builder)
    {
        return $builder->with('values.translations','translations');
    }
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'id',
                title: 'id',
            ),
            new Column(
                key: 'title',
                title: 'title',
            ),
            new Column(
                key: 'values',
                title: 'values',
                valueName: 'value',
            ),
            new Column(
                key: 'created_at',
                title: 'created',
            ),
        );
    }
    public function actions(): Actions
    {
        return new Actions(
            new Action(
                key: 'edit',
                icon: 'ri-pencil-line',
            ),
            new Action(
                key: 'destroy',
                icon: 'ri-delete-bin-line',
                confirm: true,
                style: 'btn-red',
                confirm_title: 'delete option?',
                confirm_description: 'confirm delete option',
            ),
        );
    }
    public function filters(): Filters
    {
        return new Filters(
            new Filter(
                key: 'search',
                title: 'пошук',
            ),
        );
    }
    public function actionDestroy(Option $option){
        $option->delete();
    }
    public function actionEdit(Option $option){
        return redirect()->route('admin.options.edit',$option->id);
    }
}
