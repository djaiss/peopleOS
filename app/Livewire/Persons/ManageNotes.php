<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use App\Models\Note;
use App\Models\Person;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
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
    public int $editedNoteId = 0;

    #[Locked]
    public Person $person;

    #[Validate('required|string|min:3|max:20000')]
    public string $content = '';

    #[Validate('required|string|min:3|max:20000')]
    public string $editedContent = '';

    public function mount(Collection $notes, Person $person): void
    {
        $this->notes = $notes->isEmpty() ? collect() : $notes;

        $this->person = $person;
    }

    public function render()
    {
        return view('livewire.persons.manage-notes');
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

    public function edit(int $noteId): void
    {
        $this->editedNoteId = $noteId;

        $note = $this->notes->firstWhere('id', $noteId);
        $this->editedContent = $note['content'];
    }

    public function update(): void
    {
        $this->validate([
            'editedContent' => 'required|string|min:3|max:20000',
        ]);

        $note = Note::where('id', $this->editedNoteId)->first();

        $note = (new UpdateNote(
            user: Auth::user(),
            note: $note,
            content: $this->editedContent,
        ))->execute();

        Toaster::success(__('Note updated'));

        $note = [
            'id' => $note->id,
            'content' => $note->content,
            'created_at' => $note->created_at->format('M j, Y'),
        ];

        $this->notes = $this->notes->map(fn (array $existingNote): array => $existingNote['id'] === $this->editedNoteId ? $note : $existingNote);

        $this->resetEdit();
    }

    public function resetEdit(): void
    {
        $this->editedNoteId = 0;
        $this->content = '';
        $this->editedContent = '';
        $this->resetErrorBag();
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
