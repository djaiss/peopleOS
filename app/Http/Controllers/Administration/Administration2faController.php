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

class Administration2faController extends Controller
{
    public function new(): View
    {

        return view('administration.security.partials.2fa-new');
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
