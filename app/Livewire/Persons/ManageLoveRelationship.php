<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\LoveRelationship;
use App\Models\Person;
use App\Services\CreateLoveRelationship;
use App\Services\CreatePerson;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageLoveRelationship extends Component
{
    public Collection $potentialPartners;

    public Collection $currentRelationships;

    public Collection $pastRelationships;

    public Person $person;

    public bool $addMode = false;

    public bool $addExistingPerson = false;

    #[Validate('required|string|min:3|max:20000')]
    public string $firstName = '';

    #[Validate('nullable|string|min:3|max:20000')]
    public string $lastName = '';

    #[Validate('required|string|min:3|max:20000')]
    public string $natureOfRelationship = '';

    #[Validate('nullable|boolean')]
    public bool $active = false;

    #[Validate('nullable|boolean')]
    public bool $createEntry = false;

    public function mount(Person $person): void
    {
        $this->person = $person;
        $this->potentialPartners = Person::all();
        $this->refreshRelationships();
    }

    public function render()
    {
        return view('livewire.persons.manage-love-relationship');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-2 mb-3">
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
                <div class="animate-pulse bg-slate-200 h-8 w-full rounded-xl"></div>
            </div>
        </div>
        HTML;
    }

    private function getRelationshipDetails(LoveRelationship $relationship, bool $isNew): array
    {
        return [
            'id' => $relationship->id,
            'person' => [
                'id' => $relationship->relatedPerson->id,
                'name' => $relationship->relatedPerson->name,
            ],
            'type' => $relationship->type,
            'is_new' => $isNew,
        ];
    }

    public function refreshRelationships(): void
    {
        $this->currentRelationships = collect($this->person
            ->loveRelationships()
            ->with('relatedPerson')
            ->where('is_current', true)
            ->get()
            ->map(fn (LoveRelationship $relationship): array => $this->getRelationshipDetails($relationship, false)));

        $this->pastRelationships = collect($this->person
            ->loveRelationships()
            ->with('relatedPerson')
            ->where('is_current', false)
            ->get()
            ->map(fn (LoveRelationship $relationship): array => $this->getRelationshipDetails($relationship, false)));
    }

    public function toggleAddMode(): void
    {
        $this->resetValidation();
        $this->firstName = '';
        $this->lastName = '';
        $this->natureOfRelationship = '';
        $this->active = false;
        $this->createEntry = false;
        $this->addMode = ! $this->addMode;
    }

    public function toggleAddExistingPerson(): void
    {
        $this->addExistingPerson = ! $this->addExistingPerson;
    }

    public function storeNewPerson(): void
    {
        $this->validate([
            'firstName' => 'required|string|min:3|max:20000',
            'lastName' => 'nullable|string|min:3|max:20000',
            'natureOfRelationship' => 'required|string|min:3|max:20000',
            'active' => 'nullable|boolean',
            'createEntry' => 'nullable|boolean',
        ]);

        $person = (new CreatePerson(
            user: Auth::user(),
            gender: null,
            firstName: $this->firstName,
            lastName: $this->lastName,
            middleName: null,
            nickname: null,
            suffix: null,
            prefix: null,
            maidenName: null,
            canBeDeleted: false,
            isListed: $this->createEntry,
        ))->execute();

        $relationship = (new CreateLoveRelationship(
            user: Auth::user(),
            person: $this->person,
            relatedPerson: $person,
            type: $this->natureOfRelationship,
            isCurrent: $this->active,
            notes: null,
        ))->execute();

        $this->dispatch('relationship-updated');

        Toaster::success(__('Relationship created'));

        if ($this->active) {
            $this->currentRelationships = $this->currentRelationships
                ->map(fn (array $e): array => array_merge($e, ['is_new' => false]))
                ->prepend($this->getRelationshipDetails($relationship, true));
        } else {
            $this->pastRelationships = $this->pastRelationships
                ->map(fn (array $e): array => array_merge($e, ['is_new' => false]))
                ->prepend($this->getRelationshipDetails($relationship, true));
        }

        $this->toggleAddMode();
    }
}
