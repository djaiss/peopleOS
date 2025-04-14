<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\EmailSent;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailSent>
 */
class EmailSentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailSent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'person_id' => Person::factory(),
            'uuid' => $this->faker->uuid(),
            'email_type' => $this->faker->word(),
            'email_address' => $this->faker->email(),
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'sent_at' => $this->faker->dateTime(),
            'delivered_at' => $this->faker->dateTime(),
            'bounced_at' => $this->faker->dateTime(),
        ];
    }
}
