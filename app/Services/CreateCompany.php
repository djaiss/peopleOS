<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateCompany
{
    private Company $company;

    public function __construct(
        public User $user,
        public Vault $vault,
        public string $name,
    ) {}

    public function execute(): Company
    {
        $this->validate();
        $this->create();

        return $this->company;
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
        $this->company = Company::create([
            'vault_id' => $this->vault->id,
            'name' => $this->name,
        ]);
    }
}
