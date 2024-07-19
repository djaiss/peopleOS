<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Vault;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vault_id' => Vault::factory(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'nickname' => $this->faker->firstName(),
            'maiden_name' => $this->faker->lastName(),
            'can_be_deleted' => $this->faker->boolean(),
            'last_updated_at' => $this->faker->dateTime(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Contact $contact) {
            $contact->slug = $contact->id.'-'.$contact->first_name;
            $contact->save();
        });
    }
}
