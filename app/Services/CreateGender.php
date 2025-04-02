<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;

class CreateGender
{
    public function __construct(
        private readonly User $user,
        private readonly string $name,
    ) {}

    public function execute(): Gender
    {
        $position = Gender::where('account_id', $this->user->account_id)
            ->max('position') + 1;

        $gender = Gender::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'position' => $position,
        ]);

        $this->updateUserLastActivityDate();
        $this->logUserAction($gender);

        return $gender;
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(Gender $gender): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'gender_creation',
            description: 'Created the gender called '.$gender->name,
        )->onQueue('low');
    }
}
