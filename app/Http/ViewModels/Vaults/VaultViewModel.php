<?php

namespace App\Http\ViewModels\Vaults;

use App\Models\User;
use App\Models\Vault;

class VaultViewModel
{
    public static function data(User $user): array
    {
        $vaults = $user->vaults()
            ->where('account_id', $user->account_id)
            ->get()
            ->map(function (Vault $vault): array {
                return [
                    'id' => $vault->id,
                    'name' => $vault->name,
                    'description' => $vault->description,
                ];
            });

        return [
            'vaults' => $vaults,
        ];
    }
}
