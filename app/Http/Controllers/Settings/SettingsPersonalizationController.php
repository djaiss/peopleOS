<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsPersonalizationController extends Controller
{
    public function index(): View|string
    {
        return view('settings.personalization.index');
    }
}
