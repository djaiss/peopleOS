<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactPhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactPhoneNumber>
 */
class ContactPhoneNumberFactory extends Factory
{
    protected $model = ContactPhoneNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => Contact::factory(),
            'label' => $this->faker->word(),
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
