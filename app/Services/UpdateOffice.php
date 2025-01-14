<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateOffice
{
    public function __construct(
        public User $user,
        public Office $office,
        public string $name,
    ) {}

    /**
     * Update an office.
     * Only administrators can update an office.
     */
    public function execute(): Office
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->office;
    }

    private function validate(): void
    {
        if ($this->office->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->office->update([
            'name' => $this->name,
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
            action: 'office_update',
            description: 'Updated the office called '.$this->name,
        );
    }
}
