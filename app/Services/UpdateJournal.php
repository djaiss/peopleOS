<?php

namespace App\Services;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateJournal
{
    public function __construct(
        public User $user,
        public Journal $journal,
        public string $name,
    ) {
    }

    public function execute(): Journal
    {
        $this->validate();
        $this->update();

        return $this->journal;
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

    private function update(): void
    {
        $this->journal->name = $this->name;
        $this->journal->save();
    }
}
