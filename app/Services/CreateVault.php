<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vault;

class CreateVault
{
    private Vault $vault;

    public function __construct(
        public User $user,
        public string $name,
        public ?string $description,
    ) {}

    public function execute(): Vault
    {
        $this->create();
        $this->associateUserToVault();

        return $this->vault;
    }

    private function create(): void
    {
        $this->vault = Vault::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'description' => $this->description ?? null,
        ]);
    }

    private function associateUserToVault(): void
    {
        $this->vault->users()->save($this->user, [
            'permission' => Vault::PERMISSION_MANAGE,
        ]);
    }
}
