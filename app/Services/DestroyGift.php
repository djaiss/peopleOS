<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyGift
{
    public function __construct(
        private readonly User $user,
        private readonly Gift $gift,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $personName = $this->gift->person->name;

        $this->gift->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($personName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->gift->account_id) {
            throw new ModelNotFoundException();
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
            action: 'gift_deletion',
            description: 'Deleted a gift for '.$personName,
        );
    }
}
