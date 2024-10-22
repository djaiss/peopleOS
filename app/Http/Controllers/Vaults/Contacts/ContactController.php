<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactInformationCache;
use App\Cache\ContactListCache;
use App\Cache\ContactNotesCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Vaults\Contacts\ContactRelationshipViewModel;
use App\Models\Ethnicity;
use App\Models\Gender;
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
        $contacts = ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->value();

        return view('vaults.contacts.index', [
            'vault' => $vault,
            'contacts' => $contacts,
        ]);
    }

    public function new(Request $request): View
    {
        $vault = $request->attributes->get('vault');

        return view('vaults.contacts.new', [
            'vault' => $vault,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'gender_id' => 'required|exists:genders,id',
            'ethnicity_id' => 'nullable|exists:ethnicities,id',
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
            'marital_status' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
        ]);

        $contact = (new CreateContact(
            user: auth()->user(),
            vault: $vault,
            gender: Gender::find($validated['gender_id']),
            ethnicity: $validated['ethnicity_id'] ? Ethnicity::find($validated['ethnicity_id']) : null,
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
            maritalStatus: $validated['marital_status'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
        ))->execute();

        // regenerate the cache
        ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->refresh();

        $request->session()->flash('status', __('The contact has been created'));

        return redirect()->route('vaults.contacts.show', [
            'vault' => $vault,
            'slug' => $contact->slug,
        ]);
    }

    public function show(Request $request): View
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        $contacts = ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->value();

        $notes = ContactNotesCache::make(
            contact: $contact,
        )->value();

        $contact = ContactInformationCache::make(
            user: auth()->user(),
            contact: $contact,
        )->value();

        //$children = ContactRelationshipViewModel::index($contact)['children'];

        return view('vaults.contacts.show', [
            'vault' => $vault,
            'contact' => $contact,
            'contacts' => $contacts,
            'notes' => $notes,
            'companies' => $contact['existing_companies'],
            //'children' => $children,
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

        // regenerate the cache
        ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->refresh();

        $request->session()->flash('status', __('The contact has been deleted'));

        return redirect()->route('vaults.contacts.index', [
            'vault' => $vault,
        ]);
    }
}
