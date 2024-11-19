<?php

namespace App\Livewire\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactChildrenViewModel;
use App\Models\Contact;
use App\Services\CreateChild;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;

class ManageChildren extends Component
{
    #[Locked]
    public Contact $contact;

    #[Locked]
    public int $contactId;

    #[Locked]
    public Collection $children;

    public bool $addMode = false;

    #[Validate('nullable|string|min:3|max:100')]
    public string $name = '';

    #[Validate('required|string|in:boy,girl,other')]
    public string $gender = '';

    #[Validate('nullable|string|min:1|max:100')]
    public string $age = '';

    #[Validate('nullable|string|min:3|max:100')]
    public string $gradeLevel = '';

    #[Validate('nullable|string|min:3|max:100')]
    public string $school = '';

    public function mount()
    {
        $this->contact = Contact::find($this->contactId);
        $this->children = collect(ContactChildrenViewModel::index($this->contact));
    }

    public function render()
    {
        return view('livewire.contacts.manage-children', [
            'children' => $this->children,
        ]);
    }

    public function toggleAddMode()
    {
        $this->addMode = ! $this->addMode;
        $this->name = '';
        $this->gender = '';
        $this->age = '';
        $this->gradeLevel = '';
        $this->school = '';
        $this->resetErrorBag();
    }

    public function selectGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'nullable|string|min:3|max:100',
            'gender' => 'required|string|in:boy,girl,other',
            'age' => 'nullable|string|min:1|max:100',
            'gradeLevel' => 'nullable|string|min:3|max:100',
            'school' => 'nullable|string|min:3|max:100',
        ]);

        $child = (new CreateChild(
            user: Auth::user(),
            contact: $this->contact,
            name: $this->name,
            gender: $this->gender,
            age: $this->age,
            gradeLevel: $this->gradeLevel,
            school: $this->school,
        ))->execute();

        Toaster::success(__('Child added'));

        $child = ContactChildrenViewModel::child($child);

        $this->children = $this->children->prepend($child);

        $this->toggleAddMode();
    }
}
