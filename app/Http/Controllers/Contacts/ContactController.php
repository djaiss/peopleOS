<?php

namespace App\Http\Controllers\Contacts;

use App\Cache\VaultCache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $vaults = VaultCache::make(auth()->user())->value();

        return view('vaults.index', [
            'vaults' => $vaults,
        ]);
    }
}
