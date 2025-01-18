<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class DestroyPerson
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $personName = $this->person->name;

        $this->person->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($personName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }

        if (! $this->person->can_be_deleted) {
            throw new RuntimeException('This person cannot be deleted.');
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(string $personName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_deletion',
            description: 'Deleted the person called '.$personName,
        );
    }
}
