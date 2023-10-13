<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $subcategories = $category->subcategories;
        if ($subcategories->isEmpty()) {
            return view('category.show', [
                'category' => $category,
            ]);
        }
        return view('subcategory.index', [
            'categories' => $subcategories,
            'parenCategory' => $category,
        ]);
    }
}
