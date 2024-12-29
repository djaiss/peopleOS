<?php

namespace App\Services;

use App\Models\Journal;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateJournal
{
    private Journal $journal;

    public function __construct(
        public User $user,
        public Vault $vault,
        public string $name,
    ) {}

    public function execute(): Journal
    {
        $this->validate();
        $this->create();

        return $this->journal;
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->vault->id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function create(): void
    {
        $this->journal = Journal::create([
            'vault_id' => $this->vault->id,
            'name' => $this->name,
        ]);
    }
}
