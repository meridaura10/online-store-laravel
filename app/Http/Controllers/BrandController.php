<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show(Brand $brand)
    {
        seo()->generateSeoDynamic($brand);
        return view('brand.show', compact('brand'));
    }
}
