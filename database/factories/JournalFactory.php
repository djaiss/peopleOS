<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Journal>
 */
class JournalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Journal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Journal $journal): void {
            $journal->slug = $journal->id . '-' . Str::lower($journal->name);
            $journal->save();
        });
    }
}
