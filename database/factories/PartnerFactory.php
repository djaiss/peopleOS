<?php

namespace Database\Factories;

use App\Enums\ChildGender;
use App\Models\Child;
use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => Contact::factory(),
            'marital_status_id' => MaritalStatus::factory(),
            'name' => $this->faker->text(),
            'occupation' => $this->faker->text(),
        ];
    }
}
