<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Person;
use Livewire\Attributes\On;

class DisplayPersonInformation
{
    public Person $person;

    public ?string $title = null;

    public function mount(Person $person): void
    {
        $this->person = $person;

        $this->title = $this->person->workHistories()
            ->where('active', true)
            ->first()?->job_title;
    }

    public function render()
    {
        return view('livewire.persons.display-person-information');
    }

    #[On('work-history-updated')]
    #[On('name-updated')]
    public function refresh(): void
    {
        $this->person->refresh();

        // check to see if the person has a title on an active job
        $this->title = $this->person->workHistories()
            ->where('active', true)
            ->first()?->job_title;
    }
}
