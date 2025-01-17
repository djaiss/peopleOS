<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AccountDeletionReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountDeletionReason>
 */
class AccountDeletionReasonFactory extends Factory
{
    protected $model = AccountDeletionReason::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reason' => fake()->text(),
        ];
    }
}
