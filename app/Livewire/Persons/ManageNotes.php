<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Note;
use App\Models\Person;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageNotes extends Component
{
    public Collection $notes;

    #[Locked]
    public Person $person;

    #[Validate('required|string|min:3|max:255')]
    public string $content = '';

    public function mount(Collection $notes, Person $person): void
    {
        $this->notes = $notes->isEmpty() ? collect() : $notes;

        $this->person = $person;
    }

    public function render()
    {
        return view('livewire.persons.manage-notes');
    }

    private function getNotes(): void
    {
        $this->notes = Note::where('person_id', $this->person->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Note $note): array => [
                'id' => $note->id,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M j, Y'),
                'is_new' => false,
            ]);
    }

    public function store(): void
    {
        $this->validate([
            'content' => 'required|string|min:3|max:20000',
        ]);

        $note = (new CreateNote(
            user: Auth::user(),
            person: $this->person,
            content: $this->content,
        ))->execute();

        Toaster::success(__('Note created'));

        $this->reset('content');

        // mark all previous notes as not new, then add the new note as new
        $this->notes = $this->notes
            ->map(fn (array $e): array => array_merge($e, ['is_new' => false]))
            ->prepend([
                'id' => $note->id,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M j, Y'),
                'is_new' => true,
            ]);
    }

    public function delete(int $noteId): void
    {
        $note = Note::where('id', $noteId)->first();

        (new DestroyNote(
            user: Auth::user(),
            note: $note,
        ))->execute();

        Toaster::success(__('Note deleted'));

        $this->notes = $this->notes->reject(fn (array $note): bool => $note['id'] === $noteId);
    }
}
