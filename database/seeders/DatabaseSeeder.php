<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\OptionValue;
use App\Models\Product;
use App\Models\Property;
use App\Models\SkuReview;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            PropertySeed::class,
            OptionValueSeeder::class,
            AdminSeed::class,
            BrandCategorySeeder::class,
        ]);


        User::factory(15)->create();

        $optionValues = OptionValue::all();




        Product::factory(100)->create()->each(function ($product) use ($optionValues) {

            $categories = Category::query()->inRandomOrder()->where('parent_id', '!=', null)->doesntHave('subcategories')->limit(50)->get();

            $product->categories()->attach($categories);

            foreach ($categories as $category) {
                $properties = $category->properties()->with('values')->get()->toArray();

                $propertyValueIds = array_map(function ($item) {
                    return $item['values'][fake()->numberBetween(0, count($item['values']) - 1)]['id'];
                }, $properties);


                $product->propertiesValues()->attach($propertyValueIds);
            }
            $variationValuesColor = $optionValues->where('option_id', '1')->pluck('id');
            $variationValuesMemory = $optionValues->where('option_id', '2')->pluck('id');
            $variationValuesSize = $optionValues->where('option_id', '3')->pluck('id');
            $variationValuesStyle = $optionValues->where('option_id', '4')->pluck('id');

            for ($i = 0; $i < fake()->numberBetween(2, 4); $i++) {

                $colorId = $variationValuesColor->random();
                $memory = $variationValuesMemory->random();
                $size = $variationValuesSize->random();
                $style = $variationValuesStyle->random();


                $sku = $product->skus()->create([
                    'status' => 1,
                    'price' => fake()->randomFloat(2, 10, 1000),
                    'quantity' => fake()->randomNumber(),
                ]);



                $images = Storage::files('fakeImages/skus');

                $sku->values()->attach(
                    [
                        $colorId,
                        $memory,
                        $size
                    ]
                );

                $sku->update([
                    'slug' => str()->slug($sku->name),
                ]);

                $sku->save();
                gc_collect_cycles();
                for ($j = 0; $j < fake()->numberBetween(1, 3); $j++) {
                    $sku->images()->create([
                        'path' => $images[fake()->numberBetween(0, count($images) - 1)],
                        'disk' => 'local',
                    ]);
                    SkuReview::factory()->create([
                        'sku_id' => $sku->id,
                        'comment' => $j < 4 ? fake()->text(100) : null,
                    ]);
                }
            }
            gc_collect_cycles();
        });
    }
}
