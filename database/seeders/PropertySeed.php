<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'дісплей' => [
                'width' => ['20cм', '40см', '60см'],
                'height' => ['15cм', '25см', '45см'],
            ],
            'Процесор' => [
                'Процесор' => ['Шестиядерний AMD Ryzen 5 5625U (2.3 - 4.3 ГГц)', 'Процессор AMD Ryzen 7 5700X 3.4(4.6)GHz 32MB sAM4 Box (100-100000926WOF)', 'Процесор Intel Core i9-13900K 3.0GHz/36MB (BX8071513900K) s1700 BOX'],
                'Операційна система' => ['без OC', 'windows', 'mac', 'ios'],
                'Покоління процесора AMD' => ['zen 1', 'zen 2', 'zen 3'],
            ],
            'Корпус' => [
                'Вага, кг' => ['1k', '2k', '3k', '4k', '5k', '6k'],
                'Ємність акумулятора' => ['50 Вт*год', '70 Вт*год', '30 Вт*год'],
                'Маніпулятори' => ['Тачпад', 'сенсор'],
            ]
        ];

        foreach ($data as $title => $subs) {
            $categories = Category::query()->whereDoesntHave('subCategories')->inRandomOrder()->limit(2)->get();

            $property = Property::create([
                'en' => [
                    'title' => $title,
                ],
                'parent_id' => null,
            ]);
            foreach ($subs as $title => $values) {
                $subProperty =  $property->subproperties()->create([
                    'en' => [
                        'title' => $title,
                    ],
                    'parent_id' => $property->id,
                ]);
                $subProperty->categories()->sync($categories);
                foreach ($values as $key => $value) {
                    $subProperty->values()->create([
                        'en' => [
                            'value' => $value,
                        ],
                    ]);
                }
            }
        }
    }
}
