<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Gender;
use App\Models\Person;
use App\Services\UpdatePerson;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageNames extends Component
{
    public Collection $genders;

    #[Locked]
    public Person $person;

    #[Validate('required|string|min:3|max:20000')]
    public string $firstName = '';

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $lastName = null;

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $middleName = null;

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $nickName = null;

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $suffix = null;

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $prefix = null;

    #[Validate('nullable|string|min:3|max:20000')]
    public ?string $maidenName = null;

    #[Validate('nullable|integer|exists:genders,id')]
    public ?int $genderId = null;

    public function mount(Collection $genders, Person $person): void
    {
        $this->genders = $genders;
        $this->person = $person;

        $this->setValues();
    }

    public function render()
    {
        return view('livewire.persons.manage-names');
    }

    private function setValues(): void
    {
        $this->firstName = $this->person->first_name;
        $this->lastName = $this->person->last_name;
        $this->middleName = $this->person->middle_name;
        $this->nickName = $this->person->nickname;
        $this->suffix = $this->person->suffix;
        $this->prefix = $this->person->prefix;
        $this->maidenName = $this->person->maiden_name;
        $this->genderId = $this->person->gender_id;
    }

    public function store(): void
    {
        $this->validate([
            'firstName' => 'required|string|min:3|max:20000',
            'lastName' => 'nullable|string|min:3|max:20000',
            'middleName' => 'nullable|string|min:3|max:20000',
            'nickName' => 'nullable|string|min:3|max:20000',
            'suffix' => 'nullable|string|min:3|max:20000',
            'prefix' => 'nullable|string|min:3|max:20000',
            'maidenName' => 'nullable|string|min:3|max:20000',
            'genderId' => 'nullable|integer|exists:genders,id',
        ]);

        $gender = Gender::find($this->genderId);

        $this->person = (new UpdatePerson(
            user: Auth::user(),
            person: $this->person,
            firstName: $this->firstName,
            lastName: $this->lastName,
            middleName: $this->middleName,
            nickname: $this->nickName,
            suffix: $this->suffix,
            prefix: $this->prefix,
            maidenName: $this->maidenName,
            gender: $gender,
            canBeDeleted: false,
        ))->execute();

        $this->setValues();

        Toaster::success(__('Person updated'));

        $this->redirectRoute('persons.settings.index', [
            'slug' => $this->person->slug,
        ]);
    }
}
