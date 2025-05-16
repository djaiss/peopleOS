<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateEncounter
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly Encounter $encounter,
        private readonly Carbon $seenAt,
        private readonly ?string $context = null,
    ) {}

    public function execute(): Encounter
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->encounter;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->encounter->account_id) {
            throw new ModelNotFoundException();
        }

        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->encounter->update([
            'seen_at' => $this->seenAt,
            'context' => $this->context ?? null,
        ]);
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
            action: 'encounter_update',
            description: 'Updated having seen '.$this->encounter->person->name,
        )->onQueue('low');
    }
}
