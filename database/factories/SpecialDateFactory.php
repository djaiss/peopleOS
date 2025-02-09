<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Person;
use App\Models\SpecialDate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpecialDate>
 */
class SpecialDateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpecialDate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'account_id' => Account::factory(),
            'should_be_reminded' => fake()->boolean(),
            'year' => fake()->year(),
            'month' => fake()->month(),
            'day' => fake()->dayOfMonth(),
            'name' => fake()->name(),
        ];
    }
}
