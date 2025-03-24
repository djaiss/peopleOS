<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\JournalTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JournalTemplate>
 */
class JournalTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JournalTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'name' => fake()->sentence(),
            'content' => fake()->paragraph(),
        ];
    }
}
