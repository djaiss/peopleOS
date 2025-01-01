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
        $templates = Template::where('account_id', Auth::user()->account_id)
            ->orderBy('name')
            ->get()
            ->map(fn (Template $template) => [
                'id' => $template->id,
                'name' => $template->name,
                'content' => $template->content,
            ]);

        return view('settings.templates.index', [
            'templates' => $templates,
            'routes' => [
                'template' => [
                    'new' => route('settings.templates.new'),
                ],
            ],
        ]);
    }

    public function new(): View
    {
        return view('settings.templates.new');
    }
}
