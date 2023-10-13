<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\Brand;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Index extends Table
{
    public function model(): string
    {
        return Brand::class;
    }
    public function title(): string
    {
        return 'Brands';
    }
    public function createdLink()
    {
        return route('admin.brands.create');
    }
    public function extendQuery(Builder $builder)
    {

    }
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'id',
                title: 'id',
            ),
            new Column(
                key: 'name',
                title: 'name',
            ),
            new Column(
                key: 'created_at',
                title: 'created',
                view: 'default:date',
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
                confirm_title: 'delete brand?',
                confirm_description: 'confirm delete brand',
            )   
        );
    }
    public function filters(): Filters
    {
        return new Filters(
            new Filter(
                key: 'search',
                title: 'Search',
                view: "default:text",
            ),
        );
    }
    public function actionEdit(Brand $brand)
    {
        redirect()->route('admin.brands.edit', compact('brand'));
    }
    public function actionDestroy(Brand $brand)
    {
        $brand->delete();
    }
}
