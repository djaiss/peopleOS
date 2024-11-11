<?php

namespace App\Http\Controllers\Settings\Api;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Settings\Api\ApiIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingsApiAccessController extends Controller
{
    public function index(Request $request): View|string
    {
        return view('settings.api.index', [
            'tokens' => ApiIndexViewModel::data(),
        ]);
    }

    public function new(): View
    {
        return view('settings.api.new');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token_name' => 'required|string|max:255',
        ]);

        $token = $request->user()->createToken($validated['token_name']);

        return Redirect::route('settings.api.index')
            ->with('key', $token->plainTextToken)
            ->success(trans('The key has been created'));
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        auth()->user()->tokens()->where('id', $id)->delete();

        return Redirect::route('settings.api.index')
            ->success(trans('The key has been revoked'));
    }
}
