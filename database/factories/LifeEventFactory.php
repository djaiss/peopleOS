<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\LifeEvent;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LifeEvent>
 */
class LifeEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LifeEvent::class;

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
            'special_date_id' => null,
            'description' => $this->faker->sentence(),
            'comment' => $this->faker->optional()->paragraph(),
            'icon' => $this->faker->optional()->word(),
            'bg_color' => $this->faker->optional()->hexColor(),
            'text_color' => $this->faker->optional()->hexColor(),
            'happened_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
