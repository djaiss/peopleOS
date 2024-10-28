<?php

namespace App\Services;

use App\Models\MaritalStatus;
use App\Models\User;

class CreateMaritalStatus
{
    private MaritalStatus $maritalStatus;

    public function __construct(
        public User $user,
        public string $label,
    ) {}

    public function execute(): MaritalStatus
    {
        $this->create();

        return $this->maritalStatus;
    }

    private function create(): void
    {
        $this->maritalStatus = MaritalStatus::create([
            'account_id' => $this->user->account_id,
            'label' => $this->label,
        ]);
    }
}
