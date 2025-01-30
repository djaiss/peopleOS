<?php

namespace App\Livewire\Persons;

use App\Models\Person;
use Illuminate\Support\Collection;
use Livewire\Component;

class ManageLoveRelationship extends Component
{
    public Collection $potentialPartners;

    public Collection $currentPartners;

    public Collection $pastPartners;

    public bool $addMode = false;

    public bool $addExistingPerson = false;

    public function mount(): void
    {
        $this->potentialPartners = Person::all();
        $this->currentPartners = collect();
        $this->pastPartners = collect();
    }

    public function render()
    {
        return view('livewire.persons.manage-love-relationship');
    }

    public function toggleAddMode(): void
    {
        $this->addMode = !$this->addMode;
    }

    public function toggleAddExistingPerson(): void
    {
        $this->addExistingPerson = !$this->addExistingPerson;
    }
}
