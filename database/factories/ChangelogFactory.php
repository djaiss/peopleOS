<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Changelog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Changelog>
 */
class ChangelogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Changelog>
     */
    protected $model = Changelog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);
        return [
            'pull_request_url' => fake()->unique()->url(),
            'title' => $title,
            'description' => fake()->paragraph(),
            'slug' => Str::slug($title) . '-' . fake()->unique()->randomNumber(5),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
