<?php

namespace App\Http\Controllers\Settings\Preferences;

use App\Cache\ContactListCache;
use App\Http\Controllers\Controller;
use App\Http\ViewModels\Settings\Preferences\PreferencesIndexViewModel;
use App\Services\UpdateNameOrderPreferences;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsPreferencesNameOrderController extends Controller
{
    public function index(): string
    {
        $view = PreferencesIndexViewModel::data(auth()->user());

        return view('settings.preferences.name_order.index', [
            'view' => $view,
        ])->fragment('show');
    }

    public function edit(): View
    {
        $view = PreferencesIndexViewModel::data(auth()->user());

        return view('settings.preferences.name_order.edit', [
            'view' => $view,
        ]);
    }

    public function update(Request $request): string
    {
        $validated = $request->validate([
            'name-order' => 'string|required',
        ]);

        (new UpdateNameOrderPreferences(
            user: auth()->user(),
            nameOrder: $validated['name-order'],
        ))->execute();

        // reset the cache that contains the contact list for the user to
        // refresh the contact names
        foreach (auth()->user()->vaults as $vault) {
            ContactListCache::make(
                user: auth()->user(),
                vault: $vault,
            )->forget();
        }

        $view = PreferencesIndexViewModel::data(auth()->user());

        return view('settings.preferences.name_order.index', [
            'view' => $view,
        ])->fragment('show');
    }
}
