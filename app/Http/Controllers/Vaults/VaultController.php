<?php

namespace App\Http\Controllers\Vaults;

use App\Cache\ContactListCache;
use App\Cache\UserVaultsCache;
use App\Http\Controllers\Controller;
use App\Services\CreateVault;
use App\Services\DestroyVault;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class VaultController extends Controller
{
    public function index(): Response
    {
        $vaults = UserVaultsCache::make(auth()->user())->value();

        return Inertia::render('Vault/Index');
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

        $vault = (new CreateVault(
            user: auth()->user(),
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        UserVaultsCache::make(
            user: auth()->user(),
        )->forget();

        $request->session()->flash('status', __('The vault has been created'));

        return redirect()->route('vaults.show', $vault);
    }

    public function show(Request $request): View
    {
        $vault = $request->attributes->get('vault');

        return view('vaults.show', [
            'vault' => $vault,
        ]);
    }

    public function destroy(Request $request)
    {
        (new DestroyVault(
            user: auth()->user(),
            vault: $request->attributes->get('vault'),
        ))->execute();

        UserVaultsCache::make(
            user: auth()->user(),
        )->refresh();

        ContactListCache::make(
            user: auth()->user(),
            vault: $request->attributes->get('vault'),
        )->refresh();

        $request->session()->flash('status', __('The vault has been deleted'));

        return redirect()->route('vaults.index');
    }
}
