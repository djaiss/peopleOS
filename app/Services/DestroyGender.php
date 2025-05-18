<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyGender
{
    public function __construct(
        private readonly User $user,
        private readonly Gender $gender,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $genderName = $this->gender->name;

        $this->gender->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($genderName);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->gender->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(string $genderName): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'gender_deletion',
            description: 'Deleted the gender called ' . $genderName,
        )->onQueue('low');
    }
}
