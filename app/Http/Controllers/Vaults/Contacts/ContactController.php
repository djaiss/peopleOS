<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use App\Services\CreateContact;
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
        ]);

        $contact = (new CreateContact(
            user: auth()->user(),
            vault: $vault,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            nickname: $validated['nickname'],
            middleName: $validated['middle_name'],
            maidenName: $validated['maiden_name'],
            prefix: $validated['prefix'],
            suffix: $validated['suffix'],
        ))->execute();

        // regenerate the cache
        ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->forget();

        ContactListCache::make(
            user: auth()->user(),
            vault: $vault,
        )->value();

        $request->session()->flash('status', __('The contact has been created'));

        return redirect()->route('vault.contacts.show', [
            'vault' => $vault,
            'slug' => $contact->slug,
        ]);
    }

    public function show(Request $request): View
    {
        $vault = $request->attributes->get('vault');
        $contact = $request->attributes->get('contact');

        return view('vaults.contacts.show', [
            'vault' => $vault,
            'contact' => $contact,
        ]);
    }
}
