<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyEncounter
{
    public function __construct(
        private readonly User $user,
        private readonly Encounter $encounter,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->delete();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->encounter->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function delete(): void
    {
        $this->encounter->delete();
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->encounter->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'encounter_deletion',
            description: 'Deleted having seen '.$this->encounter->person->name,
        )->onQueue('low');
    }
}
