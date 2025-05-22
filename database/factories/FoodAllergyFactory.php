<?php

namespace Database\Factories;

use App\Models\FoodAllergy;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodAllergy>
 */
class FoodAllergyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FoodAllergy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allergies = [
            'Peanuts',
            'Tree Nuts',
            'Milk',
            'Eggs',
            'Soy',
            'Wheat',
            'Fish',
            'Shellfish',
            'Gluten',
            'Lactose',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($allergies),
            'person_id' => Person::factory(),
        ];
    }
}
