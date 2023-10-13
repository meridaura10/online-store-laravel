<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeed extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->whereDoesntHave('subCategories')->get();

        foreach ($categories as $category) {
            $att = Attribute::query()->inRandomOrder()->limit(5)->get();

            $category->attributes()->sync($att);
        }
    }
}
