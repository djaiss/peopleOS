<?php

namespace App\Services;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyJournal
{
    public function __construct(
        public User $user,
        public Journal $journal,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->destroy();
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->journal->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function destroy(): void
    {
        $this->journal->delete();
    }
}
