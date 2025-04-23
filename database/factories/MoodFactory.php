<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MoodType;
use App\Models\Entry;
use App\Models\Mood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mood>
 */
class MoodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mood::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_id' => Entry::factory(),
            'mood' => fake()->randomElement(MoodType::cases()),
            'comment' => fake()->sentence(),
        ];
    }
}
