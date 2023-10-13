<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BrandCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')->get();

        foreach ($categories as $category) {
            $randomBrands = $brands->random(10);
            
            $category->brands()->attach($randomBrands);
        }
    }
}
