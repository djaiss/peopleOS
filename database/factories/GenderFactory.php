<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gender>
 */
class GenderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gender::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'name' => fake()->randomElement(['Male', 'Female', 'Non-binary']),
            'position' => fake()->numberBetween(1, 100),
        ];
    }
}
