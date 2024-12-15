<?php

namespace App\Livewire\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactPartnerViewModel;
use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Services\CreatePartner;
use App\Services\DestroyPartner;
use App\Services\UpdatePartner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Collection;

class ManagePartners extends Component
{
    #[Locked]
    public int $contactId;

    #[Locked]
    public Contact $contact;

    #[Locked]
    public Collection $partners;

    public bool $addMode = false;

    #[Validate('nullable|string|min:3|max:100')]
    public ?string $name = null;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $occupation = null;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $numberOfYearsTogether = null;

    #[Validate('required|integer|exists:marital_statuses,id')]
    public ?int $maritalStatusId = null;

    public array $partner = [];

    #[Locked]
    public int $editedPartnerId = 0;

    public function mount()
    {
        $this->contact = Contact::find($this->contactId);
        $this->partners = collect(ContactPartnerViewModel::index($this->contact));
    }

    public function render()
    {
        $maritalStatuses = MaritalStatus::where('account_id', $this->contact->vault->account_id)
            ->get()
            ->map(fn(MaritalStatus $maritalStatus) => [
                'id' => $maritalStatus->id,
                'name' => trans($maritalStatus->getLabel()),
            ]);

        return view('livewire.contacts.manage-partners', [
            'maritalStatuses' => $maritalStatuses,
            'partners' => $this->partners,
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

    public function toggleAddMode()
    {
        $this->addMode = ! $this->addMode;
        $this->name = null;
        $this->occupation = null;
        $this->numberOfYearsTogether = null;
        $this->maritalStatusId = 1;
        $this->resetErrorBag();
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'nullable|string|min:3|max:100000',
            'occupation' => 'nullable|string|min:3|max:100000',
            'numberOfYearsTogether' => 'nullable|string|min:1|max:100000',
            'maritalStatusId' => 'required|integer|exists:marital_statuses,id',
        ]);

        $partner = (new CreatePartner(
            user: Auth::user(),
            contact: $this->contact,
            maritalStatus: MaritalStatus::find($this->maritalStatusId),
            name: $this->name,
            occupation: $this->occupation,
            numberOfYearsTogether: $this->numberOfYearsTogether,
        ))->execute();

        Toaster::success(__('Partner created'));

        $this->partner = ContactPartnerViewModel::partner($partner);
        $this->partners->push($this->partner);
        $this->toggleAddMode();

        $this->name = null;
        $this->occupation = null;
        $this->numberOfYearsTogether = null;
        $this->maritalStatusId = null;
    }

    public function editMode(int $partnerId): void
    {
        $partner = $this->partners->firstWhere('id', $partnerId);
        $this->editedPartnerId = $partnerId;
        $this->maritalStatusId = $partner['marital_status']['id'];
        $this->name = $partner['name'];
        $this->occupation = $partner['occupation'];
        $this->numberOfYearsTogether = $partner['number_of_years_together'];
    }

    public function resetEdit(): void
    {
        $this->editedPartnerId = 0;
        $this->maritalStatusId = null;
        $this->name = null;
        $this->occupation = null;
        $this->numberOfYearsTogether = null;
        $this->resetErrorBag();
    }

    public function update(): void
    {
        $this->validate([
            'maritalStatusId' => 'required|exists:marital_statuses,id',
            'name' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'numberOfYearsTogether' => 'nullable|string|min:1|max:100',
        ]);

        $partner = Partner::where('contact_id', $this->contact->id)
            ->findOrFail($this->editedPartnerId);

        $partner = (new UpdatePartner(
            user: Auth::user(),
            partner: $partner,
            maritalStatus: MaritalStatus::find($this->maritalStatusId),
            name: $this->name,
            occupation: $this->occupation,
            numberOfYearsTogether: $this->numberOfYearsTogether,
        ))->execute();

        Toaster::success(__('Partner updated'));

        $partner = ContactPartnerViewModel::partner($partner);

        $this->partners = $this->partners->map(fn (array $existingPartner) => $existingPartner['id'] === $this->editedPartnerId ? $partner : $existingPartner);

        $this->resetEdit();
    }

    public function delete(int $partnerId): void
    {
        $partner = Partner::where('contact_id', $this->contact->id)
            ->findOrFail($partnerId);

        (new DestroyPartner(
            user: Auth::user(),
            partner: $partner,
        ))->execute();

        Toaster::success(__('Partner deleted'));

        $this->partners = $this->partners->reject(fn (array $partner) => $partner['id'] === $partnerId);
    }
}
