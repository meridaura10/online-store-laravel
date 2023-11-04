<?php

namespace App\Http\Controllers;

use App\Actions\AlsoGet;
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
        $also = AlsoGet::handle(null);

        $skus = Sku::query()
        ->whereHas('product',function($q){
            $q->where('status',1);
        })
        ->where('status',1)
        ->where('quantity','>',0)
        ->with('values.translations', 'bannerImage','product.translations','reviews')
        ->paginate(15);    
    
        return view('home.index', [
            'skus' => $skus,
            'also' => $also,
        ]);
    }
}
