<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AgeType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateAgeOfAPerson
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly string $ageType,
        private readonly ?int $estimatedAge,
        private readonly ?string $ageBracket,
        private readonly ?int $ageYear,
        private readonly ?int $ageMonth,
        private readonly ?int $ageDay,
        private readonly bool $addYearlyReminder,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        $this->person->age_type = $this->ageType;
        $this->person->save();

        return $this->person;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        match ($this->ageType) {
            AgeType::EXACT->value => $this->updateExactAge(),
            AgeType::ESTIMATED->value => $this->updateEstimatedAge(),
            AgeType::BRACKET->value => $this->updateAgeBracket(),
            AgeType::UNKNOWN->value => '',
            default => throw new Exception('Invalid age type'),
        };
    }

    private function updateExactAge(): void
    {
        if ($this->person->ageSpecialDate) {
            $this->person->ageSpecialDate->delete();
        }

        if ($this->ageYear || $this->ageMonth || $this->ageDay) {
            $specialDate = (new CreateSpecialDate(
                user: $this->user,
                person: $this->person,
                name: 'Birthday',
                year: $this->ageYear ?? null,
                month: $this->ageMonth ?? null,
                day: $this->ageDay ?? null,
                shouldBeReminded: $this->addYearlyReminder,
            ))->execute();

            $this->person->age_special_date_id = $specialDate->id;
            $this->person->save();
        }
    }

    private function updateEstimatedAge(): void
    {
        if ($this->person->ageSpecialDate) {
            $this->person->ageSpecialDate->delete();
        }

        if ($this->estimatedAge !== null && $this->estimatedAge !== 0) {
            $this->person->estimated_age = (string) $this->estimatedAge;
            $this->person->age_estimated_at = now();
            $this->person->save();
        }
    }

    private function updateAgeBracket(): void
    {
        if ($this->person->ageSpecialDate) {
            $this->person->ageSpecialDate->delete();
        }

        if ($this->ageBracket !== null && $this->ageBracket !== '' && $this->ageBracket !== '0') {
            $this->person->age_bracket = $this->ageBracket;
            $this->person->age_estimated_at = now();
            $this->person->save();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'age_update',
            description: 'Updated the age of ' . $this->person->name,
        )->onQueue('low');
    }
}
