<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TogglePastLoveRelationshipsVisibility
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();

        return $this->person;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->person->update([
            'show_past_love_relationships' => ! $this->person->show_past_love_relationships,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }
}
