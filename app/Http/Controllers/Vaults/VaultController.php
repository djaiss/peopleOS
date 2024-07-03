<?php

namespace App\Http\Controllers\Vaults;

use App\Cache\VaultCache;
use App\Http\Controllers\Controller;
use App\Services\CreateVault;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaultController extends Controller
{
    public function index(Request $request): View
    {
        $vaults = VaultCache::make(auth()->user())->value();

        return view('vaults.index', [
            'vaults' => $vaults,
        ]);
    }

    public function new(): View
    {
        return view('vaults.new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        (new CreateVault(
            user: auth()->user(),
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        VaultCache::make(
            user: auth()->user(),
        )->forget();

        $request->session()->flash('status', __('The vault has been created'));

        return redirect()->route('vaults.index');
    }
}
