<?php

namespace App\Http\Controllers;

use App\Actions\SubcategoriesGet;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    public function show(Category $category, SubcategoriesGet $action)
    {
        seo()->generateSeoDynamic($category);
        $category->load('brands.image');
        
        if ($category->parent_id) {
            return view('category.show', [
                'category' => $category,
            ]);
        }

        $categories = $action->handle($category);

        return view('subcategory.index', [
            'categories' => $categories,
            'parenCategory' => $category,
        ]);
    }
}
