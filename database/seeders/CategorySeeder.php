<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
  public function run()
  {
    $imagesRoot = Storage::files('fakeImages/categories/root');
    $imagesChild = Storage::files('fakeImages/categories/child');
    $faker = Faker::create('en');
    for ($iroot = 0; $iroot < 6; $iroot++) {

      $name = $faker->realText(30);
      $category = Category::create([
        'en' => [
          'name' => $name,
        ],
        'slug' => str()->slug($name),
        'parent_id' => null,
      ]);

      $category->image()->create([
        'order' => 0,
        'disk' => 'local',
        'path' => $imagesRoot[fake()->numberBetween(0, count($imagesRoot) - 1)],
      ]);

      for ($isub = 0; $isub < 12; $isub++) {
        $name = $faker->realText(30);
        $sub = $category->subCategories()->create([
          'en' => [
            'name' => $name,
          ],
          'slug' => str()->slug($name),
        ]);
        $sub->image()->create([
          'order' => 0,
          'disk' => 'local',
          'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
        ]);


        if ($iroot <= 2) {
          if ($isub <= 5) {

            for ($i = 0; $i < $faker->numberBetween(3, 8); $i++) {
              $name = $faker->realText(30);
              $subNew =  $sub->subCategories()->create([
                'en' => [
                  'name' => $name,
                ],
                'slug' => str()->slug($name),
              ]);

              $subNew->image()->create([
                'order' => 0,
                'disk' => 'local',
                'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
              ]);
            }
          }
        }

        if ($iroot >= 4) {
          for ($i = 0; $i < $faker->numberBetween(4, 8); $i++) {
            $name = $faker->realText(30);
            $subNew =  $sub->subCategories()->create([
              'en' => [
                'name' => $name,
              ],
              'slug' => str()->slug($name),
            ]);

            $subNew->image()->create([
              'order' => 0,
              'disk' => 'local',
              'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
            ]);
          }
        }
      }
    }
  }
}
