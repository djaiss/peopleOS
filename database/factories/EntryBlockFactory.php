<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for creating EntryBlock instances for testing.
 *
 * @extends Factory<EntryBlock>
 */
class EntryBlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = EntryBlock::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_id' => Entry::factory(),
            'blockable_type' => Mood::class,
            'blockable_id' => Mood::factory(),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}
