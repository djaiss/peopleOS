<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\ViewModels\Settings\Api\ApiIndexViewModel;
use App\Http\ViewModels\Settings\Personalization\GenderViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingsPersonalizationController extends Controller
{
    public function index(): View|string
    {
        return view('settings.personalization.index');
    }
}
