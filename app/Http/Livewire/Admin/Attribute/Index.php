<?php

namespace App\Http\Livewire\Admin\Attribute;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\Attribute;
use Livewire\Component;

class Index extends Table
{
    public function title(): string{
        return 'Attributes';
    }
    public function model():string{
        return Attribute::class;
    }
    public function extendQuery(\Illuminate\Contracts\Database\Eloquent\Builder $builder){
        $builder->with('translations');
    }
    public function createdLink(){
        return route('admin.attributes.create');
    } 
    public function columns():Columns{
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
                key: 'property.title',
                title: 'property',
            ),
            new Column(
                key: 'categories',
                title: 'categories',
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
                confirm_title: 'delete attribute?',
                confirm_description: 'confirm delete attribute',
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
                key: 'searchToProperty',
                title: 'пошук за характеристикой',
            ),
        );
    }
    public function actionDestroy(Attribute $attribute){
        $attribute->delete();
    }
    public function actionEdit(Attribute $attribute){
        return redirect()->route('admin.attributes.edit',$attribute->id);
    }
}
