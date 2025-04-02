<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateGender
{
    public function __construct(
        private readonly User $user,
        private readonly Gender $gender,
        private readonly string $name,
        private readonly int $position,
    ) {}

    public function execute(): Gender
    {
        $this->validate();

        $this->gender->update([
            'name' => $this->name,
            'position' => $this->position,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->gender;
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

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'gender_update',
            description: 'Updated the gender called '.$this->gender->name,
        )->onQueue('low');
    }
}
