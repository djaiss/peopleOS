<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class CreateContact
{
    public Contact $contact;

    public function __construct(
        public User $user,
        public Vault $vault,
        public ?Gender $gender,
        public ?Ethnicity $ethnicity,
        public ?MaritalStatus $maritalStatus,
        public string $firstName,
        public ?string $lastName,
        public ?string $middleName,
        public ?string $nickname,
        public ?string $maidenName,
        public ?string $patronymicName,
        public ?string $tribalName,
        public ?string $generationName,
        public ?string $romanizedName,
        public ?string $nationality,
        public ?string $prefix,
        public ?string $suffix,
        public bool $canBeDeleted = true,
    ) {
    }

    public function execute(): Contact
    {
        $this->validate();
        $this->createContact();
        $this->generateSlug();
        if ($this->maritalStatus) {
            $this->createPartner();
        }

        return $this->contact;
    }

    private function validate(): void
    {
        if ($this->vault->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }

        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->vault->id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }

        // make sure the gender exists and belongs to the account
        if ($this->gender) {
            Gender::where('account_id', $this->user->account_id)
                ->findOrFail($this->gender->id);
        }

        // make sure the ethnicity exists and belongs to the account
        if ($this->ethnicity) {
            Ethnicity::where('account_id', $this->user->account_id)
                ->findOrFail($this->ethnicity->id);
        }

        // make sure the marital status exists and belongs to the account
        if ($this->maritalStatus) {
            MaritalStatus::where('account_id', $this->user->account_id)
                ->findOrFail($this->maritalStatus->id);
        }
    }

    private function createContact(): void
    {
        $this->contact = Contact::create([
            'vault_id' => $this->vault->id,
            'gender_id' => $this->gender?->id,
            'ethnicity_id' => $this->ethnicity?->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName ?? null,
            'middle_name' => $this->middleName ?? null,
            'nickname' => $this->nickname ?? null,
            'maiden_name' => $this->maidenName ?? null,
            'patronymic_name' => $this->patronymicName ?? null,
            'tribal_name' => $this->tribalName ?? null,
            'generation_name' => $this->generationName ?? null,
            'romanized_name' => $this->romanizedName ?? null,
            'nationality' => $this->nationality ?? null,
            'suffix' => $this->suffix ?? null,
            'prefix' => $this->prefix ?? null,
            'can_be_deleted' => $this->canBeDeleted,
        ]);
    }

    private function createPartner(): void
    {
        (new CreatePartner(
            user: $this->user,
            contact: $this->contact,
            maritalStatus: $this->maritalStatus,
            name: null,
            occupation: null,
            numberOfYearsTogether: null,
        ))->execute();
    }

    private function generateSlug(): void
    {
        $name = $this->contact->first_name . ' ' . $this->contact->last_name;
        $slug = $this->contact->id . '-' . Str::of($name)->slug('-');

        $this->contact->slug = $slug;
        $this->contact->save();
    }
}
