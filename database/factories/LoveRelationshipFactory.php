<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LoveRelationship;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LoveRelationship>
 */
class LoveRelationshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoveRelationship::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $person = Person::factory()->create();

        return [
            'person_id' => $person,
            'related_person_id' => Person::factory()->create([
                'account_id' => $person->account_id,
            ]),
            'type' => fake()->randomElement(['Dating', 'Married', 'Divorced', 'Ex-partner']),
            'notes' => fake()->optional()->sentence(),
            'is_current' => fake()->boolean(),
        ];
    }
}
