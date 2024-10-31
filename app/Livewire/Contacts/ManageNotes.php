<?php

namespace App\Livewire\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Models\Contact;
use App\Models\Note;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use App\Services\UpdateNote;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ManageNotes extends Component
{
    #[Locked]
    public Contact $contact;

    #[Locked]
    public int $contactId;

    #[Locked]
    public Collection $notes;

    #[Locked]
    public int $editedNoteId = 0;

    #[Validate('required|string|min:3|max:100000')]
    public string $editedBody = '';

    #[Validate('required|string|min:3|max:100000')]
    public string $body = '';

    public function mount()
    {
        $this->contact = Contact::find($this->contactId);
        $this->notes = collect(ContactNotesViewModel::index($this->contact));
    }

    public function render()
    {
        return view('livewire.contacts.manage-notes', [
            'notes' => $this->notes,
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-3 mb-3">
                <div class="animate-pulse bg-slate-200 h-[125px] w-full rounded-xl"></div>
                <div class="space-y-2">
                    <div class="bg-slate-200 animate-pulse rounded-md bg-muted h-4 w-full"></div>
                    <div class="bg-slate-200 animate-pulse rounded-md bg-muted h-4 w-[200px]"></div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="animate-pulse bg-slate-200 h-[125px] w-full rounded-xl"></div>
                <div class="space-y-2">
                    <div class="bg-slate-200 animate-pulse rounded-md bg-muted h-4 w-full"></div>
                    <div class="bg-slate-200 animate-pulse rounded-md bg-muted h-4 w-[200px]"></div>
                </div>
            </div>
        </div>
        HTML;
    }

    public function store(): void
    {
        $this->validate([
            'body' => 'required|string|min:3|max:100000',
        ]);

        $note = (new CreateNote(
            user: auth()->user(),
            contact: $this->contact,
            body: $this->body,
        ))->execute();

        Toaster::success(__('Note created'));

        $note = ContactNotesViewModel::note($note);

        $this->notes = $this->notes->prepend($note);

        $this->body = '';
    }

    public function editMode(int $noteId): void
    {
        $this->editedNoteId = $noteId;

        $note = $this->notes->firstWhere('id', $noteId);
        $this->editedBody = $note['body_raw'];
    }

    public function resetEdit(): void
    {
        $this->editedNoteId = 0;
        $this->editedBody = '';
        $this->resetErrorBag();
    }

    public function update(int $noteId): void
    {
        $this->validate([
            'editedBody' => 'required|string|min:3|max:100000',
        ]);

        $note = Note::where('contact_id', $this->contact->id)
            ->findOrFail($noteId);

        $note = (new UpdateNote(
            user: auth()->user(),
            note: $note,
            body: $this->editedBody,
        ))->execute();

        $this->resetEdit();

        Toaster::success(__('Note updated'));

        $note = ContactNotesViewModel::note($note);

        $this->notes = $this->notes->map(fn (array $existingNote) => $existingNote['id'] === $noteId ? $note : $existingNote);
    }

    public function delete(int $noteId): void
    {
        $note = Note::where('contact_id', $this->contact->id)
            ->findOrFail($noteId);

        (new DestroyNote(
            user: auth()->user(),
            note: $note,
        ))->execute();

        Toaster::success(__('Note deleted'));

        $this->notes = $this->notes->reject(fn (array $note) => $note['id'] === $noteId);
    }
}
