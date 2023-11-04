<?php

namespace App\Actions;

use App\Models\Category;

class SubcategoriesGet
{
    public function handle(Category $category)
    {
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
        return $categories;
    }
}
