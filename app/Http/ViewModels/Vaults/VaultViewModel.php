<?php

namespace App\Http\ViewModels\Vaults;

use App\Helpers\VaultHelper;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
