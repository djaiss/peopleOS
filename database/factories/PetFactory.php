<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Pet;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'person_id' => Person::factory(),
            'name' => fake()->name(),
            'species' => fake()->randomElement(['dog', 'cat', 'bird', 'fish', 'hamster', 'rabbit']),
            'breed' => fake()->randomElement(['Golden Retriever', 'Labrador', 'German Shepherd', 'Bulldog', 'Poodle']),
            'gender' => fake()->randomElement(['male', 'female']),
        ];
    }
}
