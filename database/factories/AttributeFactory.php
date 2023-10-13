<?php

namespace Database\Factories;
use App\Models\Attribute;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::query()->inRandomOrder()->first()->id,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Attribute $attribute) {
            $langs = localization()->getSupportedLocales();

            foreach ($langs as $lang) {
                $faker = Faker::create($lang->regional());
                $attribute->translateOrNew($lang->key())->title = $faker->realText(20);
            }

            $attribute->save();
            gc_collect_cycles();
        });
    }
}
