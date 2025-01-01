<?php

namespace App\Livewire\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactChildrenViewModel;
use App\Models\Child;
use App\Models\Contact;
use App\Services\CreateChild;
use App\Services\DestroyChild;
use App\Services\UpdateChild;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
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
    public ?string $name = null;

    #[Validate('required|string|in:boy,girl,other')]
    public ?string $gender = null;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $age = null;

    #[Validate('nullable|string|min:3|max:100')]
    public ?string $gradeLevel = null;

    #[Validate('nullable|string|min:3|max:100')]
    public ?string $school = null;

    #[Locked]
    public int $editedChildId = 0;

    public function mount(): void
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

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col space-y-3 mb-3">
                <div class="animate-pulse bg-slate-200 h-[125px] w-full rounded-xl"></div>
            </div>
        </div>
        HTML;
    }

    public function toggleAddMode(): void
    {
        $this->addMode = ! $this->addMode;
        $this->name = null;
        $this->gender = null;
        $this->age = null;
        $this->gradeLevel = null;
        $this->school = null;
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

    public function editMode(int $childId): void
    {
        $this->editedChildId = $childId;

        $child = $this->children->firstWhere('id', $childId);
        $this->name = $child['name'];
        $this->gender = $child['gender'];
        $this->age = $child['age'];
        $this->gradeLevel = $child['grade_level'];
        $this->school = $child['school'];
    }

    public function resetEdit(): void
    {
        $this->editedChildId = 0;
        $this->name = null;
        $this->gender = null;
        $this->age = null;
        $this->gradeLevel = null;
        $this->school = null;
        $this->resetErrorBag();
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'nullable|string|min:3|max:100',
            'gender' => 'required|string|in:boy,girl,other',
            'age' => 'nullable|string|min:1|max:100',
            'gradeLevel' => 'nullable|string|min:3|max:100',
            'school' => 'nullable|string|min:3|max:100',
        ]);

        $child = Child::where('contact_id', $this->contact->id)
            ->findOrFail($this->editedChildId);

        $child = (new UpdateChild(
            user: Auth::user(),
            child: $child,
            name: $this->name,
            gender: $this->gender,
            age: $this->age,
            gradeLevel: $this->gradeLevel,
            school: $this->school,
        ))->execute();

        Toaster::success(__('Child updated'));

        $child = ContactChildrenViewModel::child($child);

        $this->children = $this->children->map(fn (array $existingChild) => $existingChild['id'] === $this->editedChildId ? $child : $existingChild);

        $this->resetEdit();
    }

    public function delete(int $childId): void
    {
        $child = Child::where('contact_id', $this->contact->id)
            ->findOrFail($childId);

        (new DestroyChild(
            user: Auth::user(),
            child: $child,
        ))->execute();

        Toaster::success(__('Child deleted'));

        $this->children = $this->children->reject(fn (array $child) => $child['id'] === $childId);
    }
}
