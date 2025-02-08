<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateHowIMetInformation
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?string $howIMet,
        private readonly ?string $howIMetLocation,
        private readonly ?string $howIMetFirstImpressions,
        private readonly bool $howIMetShown,
    ) {}

    public function execute(): Person
    {
        $this->validate();
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

    private function update(): void
    {
        $this->person->update([
            'how_we_met' => $this->howIMet,
            'how_we_met_location' => $this->howIMetLocation,
            'how_we_met_first_impressions' => $this->howIMetFirstImpressions,
            'how_we_met_shown' => $this->howIMetShown,
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
