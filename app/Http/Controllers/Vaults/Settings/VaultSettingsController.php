<?php

namespace App\Http\Controllers\Vaults\Settings;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaultSettingsController extends Controller
{
    public function index(Request $request): View
    {
        $vault = $request->attributes->get('vault');

        return view('vaults.settings.index', [
            'vault' => $vault,
        ]);
    }
}
