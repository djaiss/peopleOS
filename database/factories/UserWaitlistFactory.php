<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\UserWaitlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWaitlist>
 */
class UserWaitlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserWaitlist::class;

    /**
     * Define the model's default state.
     *
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'confirmed_at' => $this->faker->dateTimeThisCentury(),
            'confirmation_code' => $this->faker->url(),
        ];
    }
}
