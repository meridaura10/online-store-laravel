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
    public function index(){
        $categories = Category::whereNull('parent_id')->get();
        $skus = Sku::inRandomOrder()->limit(30)->get();
        return view('home.index',[
            'categories' => $categories,
            'skus' => $skus,
        ]);
    }
}
