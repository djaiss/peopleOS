<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gender>
 */
class GenderFactory extends Factory
{
    protected $model = Gender::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'position' => 1,
            'label' => $this->faker->word(),
            'label_translation_key' => $this->faker->word(),
        ];
    }
}
