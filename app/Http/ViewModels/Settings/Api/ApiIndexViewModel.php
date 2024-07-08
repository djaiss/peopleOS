<?php

namespace App\Http\ViewModels\Settings\Api;

use Illuminate\Support\Collection;
use Laravel\Sanctum\PersonalAccessToken;

class ApiIndexViewModel
{
    public static function data(): Collection
    {
        return auth()->user()->tokens
            ->map(fn (PersonalAccessToken $token) => [
                'id' => $token->id,
                'name' => $token->name,
                'last_used' => $token->last_used_at ? $token?->last_used_at->diffForHumans() : trans('Never'),
            ]);
    }
}
