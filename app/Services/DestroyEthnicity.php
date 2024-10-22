<?php

namespace App\Services;

use App\Jobs\ClearCacheForAllContactsInAccount;
use App\Models\Ethnicity;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyEthnicity
{
    public function __construct(
        public User $user,
        public Ethnicity $ethnicity,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
        $this->clearCache();
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the ethnicity's
        if ($this->user->account_id !== $this->ethnicity->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function destroy(): void
    {
        $this->ethnicity->delete();
    }

    private function clearCache(): void
    {
        ClearCacheForAllContactsInAccount::dispatch($this->user->account);
    }
}
