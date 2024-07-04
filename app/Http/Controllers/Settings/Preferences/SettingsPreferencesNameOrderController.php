<?php

namespace App\Http\Controllers\Settings\Preferences;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsPreferencesNameOrderController extends Controller
{
    public function index(): View
    {
        return view('settings.preferences.name_order.show');
    }

    public function edit(): View
    {
        return view('settings.preferences.name_order.edit');
    }
}
