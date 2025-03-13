<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\CreateApiKey;
use App\Services\DestroyApiKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;

class AdministrationSecurityController extends Controller
{
    public function index(): View
    {
        $apiKeys = Auth::user()->tokens
            ->map(fn (PersonalAccessToken $token): array => [
                'id' => $token->id,
                'name' => $token->name,
                'last_used' => $token->last_used_at ? $token?->last_used_at->diffForHumans() : trans('Never'),
                'just_added' => false,
                'token' => $token->token,
            ]);

        return view('administration.security.index', [
            'apiKeys' => $apiKeys,
        ]);
    }

    public function new(): View
    {
        return view('administration.security.partials.new');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|min:3|max:255',
        ]);

        $apiKey = (new CreateApiKey(
            user: Auth::user(),
            label: $validated['label'],
        ))->execute();

        return redirect()->route('administration.security.index')
            ->with('apiKey', $apiKey)
            ->with('status', trans('API key created'));
    }

    public function destroy(Request $request, int $apiKeyId): RedirectResponse
    {
        $apiKey = Auth::user()->tokens()->where('id', $apiKeyId)->first();

        (new DestroyApiKey(
            user: Auth::user(),
            tokenId: $apiKey->id,
        ))->execute();

        return redirect()->route('administration.security.index')
            ->with('status', trans('API key deleted'));
    }
}
