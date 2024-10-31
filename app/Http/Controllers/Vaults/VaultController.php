<?php

namespace App\Http\Controllers\Vaults;

use App\Http\Controllers\Controller;
use App\Models\Vault;
use App\Services\CreateVault;
use App\Services\DestroyVault;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaultController extends Controller
{
    public function index(Request $request): View
    {
        $account = $request->attributes->get('account');

        $vaults = $account->vaults()
            ->get()
            ->map(fn (Vault $vault): array => [
                'id' => $vault->id,
                'name' => $vault->name,
                'description' => $vault->description,
                'updated_at' => $vault->updated_at->diffForHumans(),
                'routes' => [
                    'vault' => [
                        'show' => route('vaults.show', $vault),
                    ],
                ],
            ])
            ->sortBy('name');

        return view('vaults.index', [
            'vaults' => $vaults,
            'routes' => [
                'vault' => [
                    'new' => route('vaults.new'),
                ],
            ],
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

        $vault = (new CreateVault(
            user: auth()->user(),
            name: $validated['name'],
            description: $validated['description'],
        ))->execute();

        return redirect()->route('vaults.show', $vault)
            ->success(trans('The vault has been created'));
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

        $request->session()->flash('status', __('The vault has been deleted'));

        return redirect()->route('vaults.index')
            ->success(trans('The vault has been deleted'));
    }
}
