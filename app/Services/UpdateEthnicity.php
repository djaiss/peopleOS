<?php

namespace App\Services;

use App\Jobs\ClearCacheForAllContactsInAccount;
use App\Models\Ethnicity;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateEthnicity
{
    public function __construct(
        public User $user,
        public Ethnicity $ethnicity,
        public string $label,
    ) {
    }

    public function execute(): Ethnicity
    {
        $this->validate();
        $this->update();
        $this->clearCache();

        return $this->ethnicity;
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the ethnicity's
        if ($this->user->account_id !== $this->ethnicity->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->ethnicity->label = $this->label;
        $this->ethnicity->save();
    }

    private function clearCache(): void
    {
        ClearCacheForAllContactsInAccount::dispatch($this->user->account);
    }
}
