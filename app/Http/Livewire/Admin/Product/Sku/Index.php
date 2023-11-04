<?php

namespace App\Http\Livewire\Admin\Product\Sku;

use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Action;
use App\Http\Livewire\Admin\Datatable\Util\Actions;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Contracts\Database\Query\Builder;
use Livewire\Component;

class Index extends Table
{
    public bool $usePagination = false;
    public $product;
    public function mount()
    {
        parent::mount();
    }
    public function title(): string
    {
        return 'skus продукта:' . ' ' . $this->product->name;
    }
    public function model(): string
    {
        return Sku::class;
    }
    public function extendQuery(Builder $query)
    {
        $query
            ->whereHas('product', function ($q) {
                $q->where('id', $this->product->id);
            })
            ->with('product.translations', 'values.translations', 'bannerImage');
    }
    public function createdLink()
    {
        return null;
    }
    public function editedLink()
    {
        return route('admin.products.skus.form',[
            'product' => $this->product,
        ]);
    }
    public function columns(): Columns
    {
        return new Columns(
            new Column(
                key: 'id',
                title: 'id',
            ),
            new Column(
                key: 'bannerImage',
                view: 'default:image',
                sortable: false,
                title: 'image',
            ),
            new Column(
                key: 'name',
                sortable: false,
                title: 'name',
            ),
            new Column(
                key: 'slug',
                title: 'slug',
            ),
            new Column(
                key: 'price',
                title: 'price',
            ),
            new Column(
                key: 'quantity',
                title: 'count',
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
                key: 'destroy',
                icon: 'ri-delete-bin-line',
                confirm: true,
                style: 'btn-red',
                confirm_title: 'delete sku?',
                confirm_description: 'confirm delete sku',
            ),
            new Action(
                key: 'seo',
                icon: 'ri-article-line',
                style: 'btn-accent'
            ),
        );
    }
    public function actionDestroy(Sku $sku)
    {
        $sku->delete();
    }
    public function actionSeo(Sku $sku)
    {     
        redirect()->route($sku->getSeoData()['route'],$sku);
    }

    public function switchStatus(Sku $sku)
    {
        $sku->update(['status' => !$sku->status]);
    }
}
