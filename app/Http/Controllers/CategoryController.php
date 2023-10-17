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
        if ($category->parent_id) {
            return view('category.show', [
                'category' => $category,
            ]);
        }

        $categoriesWithoutSubcategoriesQuery = $category->subcategories()
            ->doesntHave('subcategories')
            ->with('translations', 'image', 'subcategories');

        $categoriesWithSubcategoriesQuery = $category->subcategories()
            ->has('subcategories')
            ->with('translations', 'image', 'subcategories.translations');

        $categoriesWithoutSubcategoriesCount = $categoriesWithoutSubcategoriesQuery->count();
        $categoriesWithSubcategoriesCount = $categoriesWithSubcategoriesQuery->count();

        $categories = collect();

        if ($categoriesWithoutSubcategoriesCount > 0) {

            $categoriesWithoutSubcategories = $categoriesWithoutSubcategoriesQuery
                ->take($categoriesWithoutSubcategoriesCount - ($categoriesWithoutSubcategoriesCount % 6))
                ->get();

            $categories = $categories->concat($categoriesWithoutSubcategories);
        }

        if ($categoriesWithSubcategoriesCount > 0) {

            $categoriesWithSubcategories = $categoriesWithSubcategoriesQuery
                ->take($categoriesWithSubcategoriesCount - ($categoriesWithSubcategoriesCount % 6))
                ->get();

            $categories = $categories->concat($categoriesWithSubcategories);
        }

        return view('subcategory.index', [
            'categories' => $categories,
            'parenCategory' => $category,
            'type' => 'fullDoesntHaveSubcategory',
        ]);
    }
}
