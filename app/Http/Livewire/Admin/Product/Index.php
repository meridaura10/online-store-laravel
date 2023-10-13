<?php

namespace App\Http\Livewire\Admin\Product;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Index extends Table
{
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'id',
                title: 'Id'
            ),
            new Column(
                key: 'name',
                title: 'name',
                sortScope: 'orderByTranslation',
            ),
            new Column(
                key: 'categories',
                title: 'categories',
                sortScope: 'sortByCategory',
            ),
            new Column(
                key: 'brand.name',
                title: 'brand',
                sortScope: 'sortByBrand'
            ),
            new Column(
                key: 'status',
                title: 'status',
                view: 'default:switch',
            ),
            new Column(
                key: 'created_at',
                title: 'Created',
                view: 'default:date',
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
            new Filter(
                key: 'status',
                title: 'Status',
                values: 'status',
                view: "default:status"
            ),
            new Filter(
                key: 'category',
                title: 'Category',
                values: 'categories',
                scope: 'filterByCategory',
                valuesKey: 'id',
                valuesName: 'name',
                view: 'default:select'
            ),
            new Filter(
                key: 'brand',
                title: 'brand',
                values: 'brands',
                valuesKey: 'id',
                valuesName: 'name',
                view: 'default:select'
            )
        );
    }
    public function categories(){
        return Category::all();

    }
    public function status(){
      return  [
            'hide' => 'Inactive',
            1 => 'Active',
      ];
    }
    public function createdLink(){
        return route('admin.products.create');
    }
    public function brands(){
        return Brand::query()->get(['name','id']);
    }
    public function model(): string
    {
        return Product::class;
    }
    public function title(): string
    {
        return 'Products';
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
                confirm_title: 'delete product?',
                confirm_description: 'confirm delete product',
            ),
            new Action(
                key: 'show',
                icon: 'ri-article-line',
            ),
        );
    }
    public function extendQuery(Builder $builder)
    {
        return $builder->with('translations','brand','categories.translations');
    }
    public function actionShow(Product $product){
        return redirect()->route('admin.products.show',compact('product'));
    }
    public function actionEdit(Product $product)
    {
        redirect()->route('admin.products.edit', compact('product'));
    }
    public function actionDestroy(Product $product)
    {
        $product->delete();
    }
    public function switchStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
    }
}
