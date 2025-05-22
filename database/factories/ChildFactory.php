<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Child;
use App\Models\Gender;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Enums\AgeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Child>
 */
class ChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'parent_id' => Person::factory(),
            'second_parent_id' => null,
            'age_special_date_id' => null,
            'gender_id' => Gender::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->optional()->lastName(),
            'age_type' => AgeType::UNKNOWN->value,
            'estimated_age' => null,
            'age_estimated_at' => null,
            'profile_photo_path' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
