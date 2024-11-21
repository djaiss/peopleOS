<?php

namespace App\Http\Controllers\Settings\Preferences;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Settings\Preferences\PreferencesIndexViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsPreferencesController extends Controller
{
    public function index(): View
    {
        $view = PreferencesIndexViewModel::data(Auth::user());

        return view('settings.preferences.index', [
            'view' => $view,
        ]);
    }
}
