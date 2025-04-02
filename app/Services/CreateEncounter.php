<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Encounter;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateEncounter
{
    private Encounter $encounter;

    public function __construct(
        public User $user,
        public Person $person,
        public Carbon $seenAt,
        public ?string $context = null,
    ) {}

    public function execute(): Encounter
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->encounter;
    }

    private function validate(): void
    {
        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $this->encounter = Encounter::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person->id,
            'seen_at' => $this->seenAt,
            'context' => $this->context ?? null,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'encounter_creation',
            description: 'Logged having seen '.$this->person->name,
        )->onQueue('low');
    }
}
