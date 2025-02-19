<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Person;
use App\Models\PersonSeenReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PersonSeenReport>
 */
class PersonSeenReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonSeenReport::class;

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
            'seen_at' => fake()->dateTimeThisCentury(),
            'period_of_time' => fake()->text(),
        ];
    }
}
