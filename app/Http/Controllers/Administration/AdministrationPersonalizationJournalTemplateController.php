<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\JournalTemplate;
use App\Services\CreateJournalTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationPersonalizationJournalTemplateController extends Controller
{
    public function new(): View
    {
        return view('administration.personalization.partials.journal-template-add');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
        ]);

        (new CreateJournalTemplate(
            user: Auth::user(),
            name: $validated['name'],
            content: $validated['content'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('success', __('Journal template created successfully'));
    }
}
