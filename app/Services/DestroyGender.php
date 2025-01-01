<?php

namespace App\Services;

use App\Jobs\ClearCacheForAllContactsInAccount;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyGender
{
    public function __construct(
        public User $user,
        public Gender $gender,
    ) {
    }

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->clearCache();
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the gender's
        if ($this->user->account_id !== $this->gender->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function destroy(): void
    {
        $this->gender->delete();
    }

    private function clearCache(): void
    {
        ClearCacheForAllContactsInAccount::dispatch($this->user->account);
    }
}
