<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePersonGiftTab
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly string $status,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();

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
            'gift_tab_shown' => $this->status,
        ]);
    }
}
