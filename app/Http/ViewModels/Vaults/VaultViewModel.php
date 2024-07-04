<?php

namespace App\Http\ViewModels\Vaults;

use App\Models\User;
use App\Models\Vault;
use Illuminate\Support\Collection;

class VaultViewModel
{
    public static function index(User $user): Collection
    {
        $vaults = $user->vaults()
            ->where('account_id', $user->account_id)
            ->get()
            ->map(function (Vault $vault): array {
                return [
                    'id' => $vault->id,
                    'name' => $vault->name,
                    'description' => $vault->description,
                    'url' => [
                        'show' => route('vaults.show', $vault),
                    ],
                ];
            });

        return $vaults;
    }
}
