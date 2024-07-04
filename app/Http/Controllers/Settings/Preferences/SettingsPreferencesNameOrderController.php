<?php

namespace App\Http\Controllers\Settings\Preferences;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

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
