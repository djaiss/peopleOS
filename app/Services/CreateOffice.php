<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Office;
use App\Models\User;

class CreateOffice
{
    private Office $office;

    public function __construct(
        public User $user,
        public string $name,
    ) {}

    /**
     * Create an office.
     * Only administrators can create an office.
     */
    public function execute(): Office
    {
        $this->validate();
        $this->createOffice();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->office;
    }

    private function validate(): void {}

    private function createOffice(): void
    {
        $this->office = Office::create([
            'name' => $this->name,
            'account_id' => $this->user->account_id,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'office_creation',
            description: 'Created the office called '.$this->name,
        );
    }
}
