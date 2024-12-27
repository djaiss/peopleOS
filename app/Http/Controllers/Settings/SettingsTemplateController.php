<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsTemplateController extends Controller
{
    public function index(): View
    {
        return view('settings.templates.index');
    }
}
