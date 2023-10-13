<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => 1,
        ];
    }

    public function configure()
    {
        $imagesRoot = Storage::files('fakeImages/categories/root');
        $imagesChild = Storage::files('fakeImages/categories/child');

        return $this->afterCreating(function (Category $category) use ($imagesRoot,$imagesChild) {
            $category->image()->create([
                'order' => 0,
                'disk' => 'local',
                'path' => $imagesRoot[$category->id - 1],
            ]);
            $langs = localization()->getSupportedLocales();

            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $category->translateOrNew($lang->key())->name = $faker->realText(30);
            }
            for ($i = 0; $i < 3; $i++) {
                $subCategory = $category->subcategories()->create([
                    'status' => 1,
                ]);
                $subCategory->image()->create([
                    'order' => 0,
                    'disk' => 'local',
                    'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
                ]);
                foreach ($langs as $lang) {
                    $faker = Faker::create($lang->regional());
                    $subCategory->translateOrNew($lang->key())->name = $faker->realText(30);
                }
                $subCategory->save();
            }
            $category->save();
            gc_collect_cycles();
        });
    }
}
