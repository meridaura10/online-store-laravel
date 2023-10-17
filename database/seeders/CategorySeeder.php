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
    for ($iroot = 0; $iroot < 12; $iroot++) {


      $category = Category::create([
        'en' => [
          'name' => $faker->realText(30),
        ],
        'parent_id' => null,
      ]);

      $category->image()->create([
        'order' => 0,
        'disk' => 'local',
        'path' => $imagesRoot[fake()->numberBetween(0, count($imagesRoot) - 1)],
      ]);

      for ($isub = 0; $isub < 12; $isub++) {

        $sub = $category->subCategories()->create([
          'en' => [
            'name' => $faker->realText(30),
          ],
        ]);
        $sub->image()->create([
          'order' => 0,
          'disk' => 'local',
          'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
        ]);


        if ($iroot <= 4) {
          if ($isub <= 5) {

            for ($i = 0; $i < $faker->numberBetween(3, 8); $i++) {

              $subNew =  $sub->subCategories()->create([
                'en' => [
                  'name' => $faker->realText(30),
                ],
              ]);

              $subNew->image()->create([
                'order' => 0,
                'disk' => 'local',
                'path' => $imagesChild[fake()->numberBetween(0, count($imagesChild) - 1)],
              ]);
            }
          }
        }

        if ($iroot >= 8) {
          for ($i = 0; $i < $faker->numberBetween(4, 8); $i++) {

            $subNew =  $sub->subCategories()->create([
              'en' => [
                'name' => $faker->realText(30),
              ],
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
