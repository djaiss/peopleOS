<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePersonInformation
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?string $timezone,
        private readonly ?string $nationalities,
        private readonly ?string $languages,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
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
            'timezone' => $this->timezone,
            'nationalities' => $this->nationalities,
            'languages' => $this->languages,
        ]);
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
            action: 'person_information_update',
            description: 'Updated general information about ' . $this->person->name,
        )->onQueue('low');
    }
}
