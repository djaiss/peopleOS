<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Ethnicity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ethnicity>
 */
class EthnicityFactory extends Factory
{
    protected $model = Ethnicity::class;

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
