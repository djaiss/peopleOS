<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class ShowPersonList extends Component
{
    public Collection $persons;

    public Person $person;

    public string $search = '';

    public function mount(Collection $persons, Person $person): void
    {
        $this->persons = $persons;
        $this->person = $person;
    }

    public function render()
    {
        $filteredPersons = $this->persons->filter(function (array $personItem): bool {
            if ($this->search === '' || $this->search === '0') {
                return true;
            }
            if (Str::contains(mb_strtolower((string) $personItem['name']), mb_strtolower($this->search))) {
                return true;
            }
            if (Str::contains(mb_strtolower((string) $personItem['nickname']), mb_strtolower($this->search))) {
                return true;
            }

            return Str::contains(mb_strtolower((string) $personItem['maiden_name']), mb_strtolower($this->search));
        });

        return view('livewire.persons.show-person-list', [
            'filteredPersons' => $filteredPersons,
        ]);
    }
}
