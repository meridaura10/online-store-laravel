<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $product = $products[0];
        $sku = Sku::first();
        dd($product->skus[0]->values);
    }
    public function show(Sku $sku)
    {
        seo()->generateSeoDynamic($sku);
        return view('product.show', compact('sku'));
    }
}
