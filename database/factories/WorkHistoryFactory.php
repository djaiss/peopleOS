<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Person;
use App\Models\WorkHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkHistory>
 */
class WorkHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'company_name' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'estimated_salary' => fake()->numberBetween(1000, 10000),
            'active' => fake()->boolean(),
        ];
    }
}
