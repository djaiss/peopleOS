<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateContact
{
    public function __construct(
        public User $user,
        public Contact $contact,
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
    ) {}

    public function execute(): Contact
    {
        $this->validate();
        $this->update();

        return $this->contact;
    }

    private function validate(): void
    {
        if ($this->contact->vault->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }

        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault->id)
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

    private function update(): void
    {
        $this->contact->gender_id = $this->gender?->id;
        $this->contact->ethnicity_id = $this->ethnicity?->id;
        $this->contact->marital_status_id = $this->maritalStatus?->id;
        $this->contact->first_name = $this->firstName;
        $this->contact->last_name = $this->lastName ?? null;
        $this->contact->middle_name = $this->middleName ?? null;
        $this->contact->nickname = $this->nickname ?? null;
        $this->contact->maiden_name = $this->maidenName ?? null;
        $this->contact->patronymic_name = $this->patronymicName ?? null;
        $this->contact->tribal_name = $this->tribalName ?? null;
        $this->contact->generation_name = $this->generationName ?? null;
        $this->contact->romanized_name = $this->romanizedName ?? null;
        $this->contact->nationality = $this->nationality ?? null;
        $this->contact->prefix = $this->prefix ?? null;
        $this->contact->suffix = $this->suffix ?? null;
        $this->contact->can_be_deleted = $this->canBeDeleted;
        $this->contact->save();
    }
}
