<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\MaritalStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaritalStatus>
 */
class MaritalStatusFactory extends Factory
{
    protected $model = MaritalStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'label' => $this->faker->word(),
            'label_translation_key' => $this->faker->word(),
        ];
    }
}
