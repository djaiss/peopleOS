<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateBackgroundInformation
{
    public function __construct(
        public User $user,
        public Contact $contact,
        public ?string $information,
    ) {}

    public function execute(): void
    {
        $this->validate();
        $this->update();
        $this->updateLastEditedDate();
    }

    private function validate(): void
    {
        // make sure the user has the permission
        $exists = $this->user->vaults()
            ->where('vaults.id', $this->contact->vault_id)
            ->exists();

        if (! $exists) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->contact->background_information = $this->information;
        $this->contact->save();
    }

    private function updateLastEditedDate(): void
    {
        $this->contact->updated_at = Carbon::now();
        $this->contact->save();
    }
}
