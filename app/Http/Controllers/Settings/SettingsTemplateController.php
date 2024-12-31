<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsTemplateController extends Controller
{
    public function index(): View
    {
        $templates = Template::where('account_id', Auth::user()->account_id)->get();

        return view('settings.templates.index', [
            'templates' => $templates,
        ]);
    }
}
