<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seo;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.product.sku.index', compact('product'));
    }
    public function seo(Sku $sku)
    {
        return view('admin.seo.dynamic.form', [
            'model' => $sku,
        ]);
    }
    public function form(Product $product)
    {
        return view('admin.product.sku.form', compact('product'));
    }
}
