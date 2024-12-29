<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateCompany
{
    public function __construct(
        public User $user,
        public Company $company,
        public string $name,
    ) {}

    public function execute(): Company
    {
        $this->validate();
        $this->update();

        return $this->company;
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->company->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->company->name = $this->name;
        $this->company->save();
    }
}
