<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactListCache;
use App\Cache\VaultCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Contacts\ContactViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $contacts = ContactListCache::make(
            user: auth()->user(),
            vault: $request->attributes->get('vault'),
        )->value();

        return view('vaults.contacts.index', [
            'contacts' => $contacts,
        ]);
    }
}
