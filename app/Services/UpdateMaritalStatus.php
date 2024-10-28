<?php

namespace App\Services;

use App\Jobs\ClearCacheForAllContactsInAccount;
use App\Models\Ethnicity;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateMaritalStatus
{
    public function __construct(
        public User $user,
        public MaritalStatus $maritalStatus,
        public string $label,
    ) {}

    public function execute(): MaritalStatus
    {
        $this->validate();
        $this->update();

        return $this->maritalStatus;
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the marital status's
        if ($this->user->account_id !== $this->maritalStatus->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->maritalStatus->label = $this->label;
        $this->maritalStatus->save();
    }
}
