<?php

namespace Database\Factories;

use App\Enums\ChildGender;
use App\Models\Child;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => Contact::factory(),
            'name' => $this->faker->text(),
            'gender' => $this->faker->randomElement(ChildGender::cases())->value,
        ];
    }
}
