<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class UpdatePerson
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?Gender $gender,
        private readonly string $maritalStatus,
        private readonly string $kidsStatus,
        private readonly string $firstName,
        private readonly ?string $lastName,
        private readonly ?string $middleName,
        private readonly ?string $nickname,
        private readonly ?string $maidenName,
        private readonly ?string $prefix,
        private readonly ?string $suffix,
        private readonly bool $canBeDeleted = true,
        private readonly bool $isListed = true,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->generateSlug();
        $this->refreshCache();

        return $this->person;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }

        // make sure the gender exists and belongs to the account
        if ($this->gender instanceof Gender) {
            Gender::where('account_id', $this->user->account_id)
                ->findOrFail($this->gender->id);
        }
    }

    private function update(): void
    {
        $this->person->update([
            'gender_id' => $this->gender?->id,
            'marital_status' => $this->maritalStatus,
            'kids_status' => $this->kidsStatus,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'middle_name' => $this->middleName,
            'nickname' => $this->nickname,
            'maiden_name' => $this->maidenName,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'can_be_deleted' => $this->canBeDeleted,
            'is_listed' => $this->isListed,
        ]);
    }

    private function generateSlug(): void
    {
        $name = $this->person->first_name.' '.$this->person->last_name;
        $slug = $this->person->id.'-'.Str::of($name)->slug('-');

        $this->person->slug = $slug;
        $this->person->save();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_update',
            description: 'Updated the person called '.$this->person->name,
        )->onQueue('low');
    }

    private function refreshCache(): void
    {
        PeopleListCache::make(
            accountId: $this->user->account_id,
        )->refresh();
    }
}
