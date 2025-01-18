<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Gender;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'slug' => fake()->slug(),
            'gender_id' => Gender::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'can_be_deleted' => true,
        ];
    }
}
