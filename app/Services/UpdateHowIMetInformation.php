<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateHowIMetInformation
{
    private ?SpecialDate $specialDate = null;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?string $howIMet,
        private readonly ?string $howIMetLocation,
        private readonly ?string $howIMetFirstImpressions,
        private readonly ?int $howIMetYear,
        private readonly ?int $howIMetMonth,
        private readonly ?int $howIMetDay,
        private readonly bool $howIMetShown,
        private readonly bool $addYearlyReminder,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->checkSpecialDate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->person;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function checkSpecialDate(): void
    {
        if ($this->person->howWeMetSpecialDate) {
            $this->specialDate = $this->person->howWeMetSpecialDate;
            $this->updateExistingSpecialDate();

            return;
        }

        if ($this->howIMetYear || $this->howIMetMonth || $this->howIMetDay) {
            $this->specialDate = (new CreateSpecialDate(
                user: $this->user,
                person: $this->person,
                name: 'How we met',
                year: $this->howIMetYear ?? null,
                month: $this->howIMetMonth ?? null,
                day: $this->howIMetDay ?? null,
                shouldBeReminded: $this->addYearlyReminder,
            ))->execute();
        }
    }

    private function updateExistingSpecialDate(): void
    {
        if (is_null($this->howIMetYear) && is_null($this->howIMetMonth) && is_null($this->howIMetDay)) {
            $this->specialDate->delete();
        } else {
            $this->specialDate = (new UpdateSpecialDate(
                user: $this->user,
                person: $this->person,
                specialDate: $this->specialDate,
                name: 'How I Met',
                year: $this->howIMetYear ?? null,
                month: $this->howIMetMonth ?? null,
                day: $this->howIMetDay ?? null,
                shouldBeReminded: $this->addYearlyReminder,
            ))->execute();
        }
    }

    private function update(): void
    {
        $this->person->update([
            'how_we_met' => $this->howIMet,
            'how_we_met_location' => $this->howIMetLocation,
            'how_we_met_first_impressions' => $this->howIMetFirstImpressions,
            'how_we_met_shown' => $this->howIMetShown,
            'how_we_met_special_date_id' => $this->specialDate?->id,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'how_i_met_information_update',
            description: 'Updated the person called '.$this->person->name.' with the how I met information',
        );
    }
}
