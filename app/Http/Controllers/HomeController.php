<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {

        $products = Product::query()
            ->with('sku', 'skus.values', 'sku.bannerImage')
            ->whereHas('skus', function ($q) {
                $q->where('skus.quantity', '>', 0);
            })
            ->where('status', 1)
            ->limit(30)
            ->get();

        return view('home.index', [
            'products' => $products,
        ]);
    }
}
