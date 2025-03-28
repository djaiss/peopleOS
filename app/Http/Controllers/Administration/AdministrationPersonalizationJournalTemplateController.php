<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\JournalTemplate;
use App\Services\CreateJournalTemplate;
use App\Services\DestroyJournalTemplate;
use App\Services\UpdateJournalTemplate;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationPersonalizationJournalTemplateController extends Controller
{
    public function new(): View
    {
        return view('administration.personalization.journal-template-add');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            (new CreateJournalTemplate(
                user: Auth::user(),
                name: $validated['name'],
                content: $validated['content'],
            ))->execute();
        } catch (Exception $e) {
            return redirect()->route('administration.personalization.journal-templates.new')
                ->withInput()
                ->withErrors(['content' => $e->getMessage()]);
        }

        return redirect()->route('administration.personalization.index')
            ->with('success', __('Journal template created successfully'));
    }

    public function edit(Request $request): View
    {
        $journalTemplateId = (int) $request->route()->parameter('journalTemplate');

        $journalTemplate = JournalTemplate::findOrFail($journalTemplateId);

        if ($journalTemplate->account_id !== Auth::user()->account_id) {
            abort(404);
        }

        return view('administration.personalization.journal-template-edit', [
            'journalTemplate' => $journalTemplate,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
        ]);

        $journalTemplate = JournalTemplate::findOrFail($request->route()->parameter('journalTemplate'));

        (new UpdateJournalTemplate(
            user: Auth::user(),
            journalTemplate: $journalTemplate,
            name: $validated['name'],
            content: $validated['content'],
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('success', __('Journal template updated successfully'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $journalTemplate = JournalTemplate::findOrFail($request->route()->parameter('journalTemplate'));

        (new DestroyJournalTemplate(
            user: Auth::user(),
            journalTemplate: $journalTemplate,
        ))->execute();

        return redirect()->route('administration.personalization.index')
            ->with('success', __('Journal template deleted successfully'));
    }
}
