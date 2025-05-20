<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Child;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Child>
 */
class ChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'parent_id' => Person::factory(),
            'second_parent_id' => Person::factory(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
