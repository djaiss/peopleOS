<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'user_id' => User::factory(),
            'user_name' => fake()->name(),
            'action' => fake()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
