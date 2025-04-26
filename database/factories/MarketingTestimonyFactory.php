<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\GiftStatus;
use App\Enums\MarketingTestimonyStatus;
use App\Models\Account;
use App\Models\MarketingTestimony;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MarketingTestimony>
 */
class MarketingTestimonyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MarketingTestimony::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(MarketingTestimonyStatus::cases())->value,
            'name_to_display' => fake()->name(),
            'url_to_point_to' => fake()->url(),
            'display_avatar' => fake()->boolean(),
            'testimony' => fake()->sentence(),
        ];
    }
}
