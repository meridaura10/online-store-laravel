<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'status' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $langs = localization()->getSupportedLocales();

            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $product->translateOrNew($lang->key())->name = $faker->realText(30);
            }
            $product->save();
            gc_collect_cycles();
        });
    }
}
