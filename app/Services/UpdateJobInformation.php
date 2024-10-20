<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateJobInformation
{
    private ?Company $company;

    public function __construct(
        public User $user,
        public Contact $contact,
        public ?string $companyName,
        public string $jobTitle,
    ) {
    }

    public function execute(): Company
    {
        $this->validate();

        if ($this->companyName) {
            $this->checkCompany();
        }
        $this->update();
        $this->updateLastEditedDate();

        return $this->company;
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault_id)
            ->wherePivot('permission', '<=', Vault::PERMISSION_EDIT)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function checkCompany(): void
    {
        // Yes. This sucks. It's not the proper way of doing it.
        // But don´t forget that the data is encrypted in the database.
        // We can´t search for the company by name. We need to iterate on each
        // company and decrypt the name to compare.
        $this->company = null;
        $companies = Company::where('vault_id', $this->contact->vault_id)->get();
        foreach ($companies as $company) {
            if (strtolower($company->name) === strtolower($this->companyName)) {
                $this->company = $company;
                break;
            }
        }

        if (! $this->company) {
            $this->company = (new CreateCompany(
                user: $this->user,
                vault: $this->contact->vault,
                name: $this->companyName
            ))->execute();
        }
    }

    private function update(): void
    {
        $this->contact->job_title = $this->jobTitle;
        $this->contact->company_id = $this->company->id;
        $this->contact->save();
    }

    private function updateLastEditedDate(): void
    {
        $this->contact->last_updated_at = Carbon::now();
        $this->contact->save();
    }
}
