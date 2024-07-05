<?php

namespace App\Http\Controllers\Vaults\Contacts;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
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
}
