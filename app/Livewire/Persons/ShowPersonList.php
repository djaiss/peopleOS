<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
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

    #[On('relationship-updated')]
    public function refreshList(): void
    {
        $this->persons = Person::where('account_id', Auth::user()->account_id)
            ->where('is_listed', true)
            ->orderBy('first_name')
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ])
            ->sortBy('name');
    }
}
