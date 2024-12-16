<?php

namespace App\Services;

use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyMaritalStatus
{
    public function __construct(
        public User $user,
        public MaritalStatus $maritalStatus,
    ) {
    }

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the marital status's
        if ($this->user->account_id !== $this->maritalStatus->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function destroy(): void
    {
        $this->maritalStatus->delete();
    }
}
