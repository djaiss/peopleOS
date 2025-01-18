<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Str;

class CreatePerson
{
    public Person $person;

    public function __construct(
        public User $user,
        public ?Gender $gender,
        public string $firstName,
        public ?string $lastName,
        public ?string $middleName,
        public ?string $nickname,
        public ?string $maidenName,
        public ?string $prefix,
        public ?string $suffix,
        public bool $canBeDeleted = true,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->createPerson();
        $this->updateUserLastActivityDate();
        $this->logUserAction();
        $this->generateSlug();

        return $this->person;
    }

    private function validate(): void
    {
        // make sure the gender exists and belongs to the account
        if ($this->gender instanceof Gender) {
            Gender::where('account_id', $this->user->account_id)
                ->findOrFail($this->gender->id);
        }
    }

    private function createPerson(): void
    {
        $this->person = Person::create([
            'account_id' => $this->user->account_id,
            'gender_id' => $this->gender?->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName ?? null,
            'middle_name' => $this->middleName ?? null,
            'nickname' => $this->nickname ?? null,
            'maiden_name' => $this->maidenName ?? null,
            'suffix' => $this->suffix ?? null,
            'prefix' => $this->prefix ?? null,
            'can_be_deleted' => $this->canBeDeleted,
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
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_creation',
            description: 'Created the person called '.$this->person->name,
        );
    }
}
