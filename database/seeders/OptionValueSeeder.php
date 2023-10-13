<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $option1 =  Option::create([
            'en' => [
                'title' => 'color'
            ]
        ]);

        $option2 = Option::create([
            'en' => [
                'title' => 'Memory'
            ]
        ]);
        $option3 =  Option::create([
            'en' => [
                'title' => 'size'
            ]
        ]);
        $option4 =  Option::create([
            'en' => [
                'title' => 'style'
            ]
        ]);;

        $option1Values = ['Black', 'White', 'Silver', 'Gold', 'Blue'];
        $option2Values = ['32GB', '64GB', '128GB', '256GB', '512GB'];
        $option3Values = ['s', 'm', 'xl', 'x'];
        $option4Values = ['sol', 'bol', 'col', 'mil'];

        foreach ($option1Values as $value) {
            OptionValue::create([
                'en' => [
                    'value' => $value,
                ],
                'option_id' => $option1->id,
            ]);
        }

        foreach ($option2Values as $value) {
            OptionValue::create([
                'en' => [
                    'value' => $value,
                ],
                'option_id' => $option2->id,
            ]);
        }

        foreach ($option3Values as $value) {
            OptionValue::create([
                'en' => [
                    'value' => $value,
                ],
                'option_id' => $option3->id,
            ]);
        }

        foreach ($option4Values as $value) {
            OptionValue::create([
                'en' => [
                    'value' => $value,
                ],
                'option_id' => $option4->id,
            ]);
        }
    }
}
