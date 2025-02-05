<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MaritalStatusType;
use App\Models\Account;
use App\Models\Gender;
use App\Models\MaritalStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gender>
 */
class MaritalStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaritalStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'name' => $this->faker->word(),
            'position' => $this->faker->numberBetween(1, 100),
            'can_be_deleted' => true,
            'type' => MaritalStatusType::COUPLE->value,
        ];
    }
}
