<?php

namespace App\Http\Livewire\Admin\Category;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Index extends Table
{
    public function model(): string
    {
        return Category::class;
    }
    public function title(): string
    {
        return 'Categories';
    }
    public function createdLink()
    {
        return route('admin.categories.create');
    }
    public function extendQuery(Builder $builder)
    {

        return $builder->with('subcategories','translations','parent');
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
                sortScope: 'orderByTranslation',
            ),
            new Column(
                sortable: false,
                key: 'parent.name',
                title: 'parent category',
            ),
            new Column(
                key: 'status',
                title: 'status',
                view: 'default:switch',
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
                confirm_title: 'delete category?',
                confirm_description: 'confirm delete category',
            )   
        );
    }
    public function filters(): Filters
    {
        return new Filters(
            new Filter(
                key: 'status',
                title: 'Status',
                values: 'status',
                view: "default:status"
            ),
            new Filter(
                key: 'search',
                title: 'Search',
                view: "default:text"
            ),
        );
    }
    public function status()
    {
        return  [
            'hide' => 'Inactive',
            1 => 'Active',
        ];
    }
    public function actionEdit(Category $category)
    {
        redirect()->route('admin.categories.edit', compact('category'));
    }
    public function actionDestroy(Category $category)
    {
        $category->delete();
    }
    public function switchStatus(Category $category)
    {
        $category->update(['status' => !$category->status]);
    }
}
