<?php

namespace App\Http\Livewire\Admin\Seo;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Models\Seo;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Table
{
    public function title(): string
    {
        return 'seos';
    }
    public function model(): string
    {
        return Seo::class;
    }
    public function extendQuery(Builder $builder)
    {
         $builder->with('translations','relation');
    }
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'id',
                title: 'id',
            ),
            new Column(
                key: 'url',
                title: 'url',
                view: 'admin.seo.columns.url'
            ),
            new Column(
                key: 'relation',
                title: 'relation',
                view: 'admin.seo.columns.relation'
            ),
            new Column(
                key: 'title',
                title: 'title',
            ),
            new Column(
                key: 'description',
                title: 'description',
            ),
            new Column(
                key: 'created_at',
                title: 'created_at',
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
                confirm_title: 'delete seo?',
                confirm_description: 'confirm delete seo',
            )
        );
    }
    public function actionEdit(Seo $seo)
    {
        $relation = $seo->relation;
        if($relation){
            $data = $seo->relation->getSeoData();
            return redirect()->route($data['route'],$relation);
        }
      
        return redirect()->route('admin.seos.edit',compact('seo'));
    }
    public function actionDestroy(Seo $seo)
    {
        $seo->delete();
    }
    public function createdLink()
    {
        return route('admin.seos.create');
    }
}
