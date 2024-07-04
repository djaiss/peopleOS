<?php

namespace App\Http\Controllers\Settings\Preferences;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsPreferencesController extends Controller
{
    public function index(): View
    {
        return view('settings.preferences.index');
    }
}
