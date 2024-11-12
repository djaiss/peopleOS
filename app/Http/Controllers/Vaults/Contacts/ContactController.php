<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Models\Ethnicity;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Services\CreateContact;
use App\Services\DestroyContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $vault = $request->attributes->get('vault');
        $contacts = ContactViewModel::index($vault);

        return view('vaults.contacts.index', [
            'vault' => $vault,
            'contacts' => $contacts,
            'routes' => [
                'contact' => [
                    'new' => route('vaults.contacts.new', $vault),
                ],
            ],
        ]);
    }

    public function new(Request $request): View
    {
        $account = $request->attributes->get('account');
        $vault = $request->attributes->get('vault');

        $ethnicities = Ethnicity::where('account_id', $account->id)
            ->get()
            ->map(fn (Ethnicity $ethnicity) => [
                'id' => $ethnicity->id,
                'name' => trans($ethnicity->getLabel()),
            ]);

        $genders = Gender::where('account_id', $account->id)
            ->get()
            ->map(fn (Gender $gender) => [
                'id' => $gender->id,
                'name' => $gender->getLabel(),
            ]);

        $maritalStatuses = MaritalStatus::where('account_id', $account->id)
            ->get()
            ->map(fn (MaritalStatus $maritalStatus) => [
                'id' => $maritalStatus->id,
                'name' => trans($maritalStatus->getLabel()),
            ]);

        return view('vaults.contacts.new', [
            'vault' => $vault,
            'ethnicities' => $ethnicities,
            'genders' => $genders,
            'maritalStatuses' => $maritalStatuses,
            'routes' => [
                'contact' => [
                    'index' => route('vaults.contacts.index', $vault),
                    'store' => route('vaults.contacts.store', $vault),
                ],
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'gender_id' => 'nullable|exists:genders,id',
            'ethnicity_id' => 'nullable|exists:ethnicities,id',
            'marital_status_id' => 'nullable|exists:marital_statuses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'patronymic_name' => 'nullable|string|max:255',
            'tribal_name' => 'nullable|string|max:255',
            'generation_name' => 'nullable|string|max:255',
            'romanized_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
        ]);

        $contact = (new CreateContact(
            user: auth()->user(),
            vault: $vault,
            gender: isset($validated['gender_id']) ? Gender::find($validated['gender_id']) : null,
            ethnicity: isset($validated['ethnicity_id']) ? Ethnicity::find($validated['ethnicity_id']) : null,
            maritalStatus: isset($validated['marital_status_id']) ? MaritalStatus::find($validated['marital_status_id']) : null,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            middleName: $validated['middle_name'],
            maidenName: $validated['maiden_name'],
            patronymicName: $validated['patronymic_name'],
            tribalName: $validated['tribal_name'],
            generationName: $validated['generation_name'],
            romanizedName: $validated['romanized_name'],
            nationality: $validated['nationality'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
        ))->execute();

        return redirect()->route('vaults.contacts.show', [
            'vault' => $vault,
            'slug' => $contact->slug,
        ])->success(trans('The contact has been created'));
    }

    public function show(Request $request): View
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        $contacts = ContactViewModel::index($vault);
        $contact = ContactViewModel::show($contact);

        return view('vaults.contacts.show', [
            'vault' => $vault,
            'contact' => $contact,
            'contacts' => $contacts,
            'companies' => $contact['existing_companies'],
            'routes' => [
                'contact' => [
                    'new' => route('vaults.contacts.new', $vault),
                ],
            ],
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        (new DestroyContact(
            user: auth()->user(),
            vault: $vault,
            contact: $contact,
        ))->execute();

        return redirect()->route('vaults.contacts.index', [
            'vault' => $vault,
        ]);
    }
}
