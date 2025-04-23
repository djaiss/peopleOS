<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AccountExportStatus;
use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Models\Account;
use App\Models\AccountExport;
use App\Models\Gender;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<AccountExport>
 */
class AccountExportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountExport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'uuid' => fake()->uuid(),
            'downloaded_at' => fake()->dateTime(),
            'status' => AccountExportStatus::STARTED->value,
        ];
    }
}
