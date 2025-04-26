<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\GiftStatus;
use App\Models\Account;
use App\Models\Encounter;
use App\Models\Gift;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gift>
 */
class GiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gift::class;

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
            'status' => fake()->randomElement(GiftStatus::cases())->value,
            'name' => fake()->word(),
            'occasion' => fake()->word(),
            'url' => fake()->url(),
        ];
    }
}
