<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LifeEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyLifeEvent
{
    public function __construct(
        private readonly User $user,
        private readonly LifeEvent $lifeEvent,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $personName = $this->lifeEvent->person->name;

        $this->lifeEvent->delete();

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction($personName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->lifeEvent->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->lifeEvent->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $personName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'life_event_deletion',
            description: 'Deleted a life event for '.$personName,
        )->onQueue('low');
    }
}
