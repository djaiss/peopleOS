<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Entry;
use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entry>
 */
class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_id' => Journal::factory(),
            'day' => fake()->dayOfMonth(),
            'month' => fake()->month(),
            'year' => fake()->year(),
        ];
    }
}
