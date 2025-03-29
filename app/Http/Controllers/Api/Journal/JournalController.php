<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Journal;

use App\Http\Controllers\Controller;
use App\Http\Resources\JournalCollection;
use App\Http\Resources\JournalResource;
use App\Models\Journal;
use App\Models\JournalTemplate;
use App\Services\CreateJournal;
use App\Services\DestroyJournal;
use App\Services\UpdateJournal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index(): JsonResource
    {
        $journals = Journal::where('account_id', Auth::user()->account_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return new JournalCollection($journals);
    }

    public function create(Request $request): JsonResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'journal_template_id' => ['nullable', 'exists:journal_templates,id'],
        ]);

        $template = null;
        if (array_key_exists('journal_template_id', $data) && $data['journal_template_id']) {
            $template = JournalTemplate::where('account_id', Auth::user()->account_id)
                ->findOrFail($data['journal_template_id']);
        }

        $journal = (new CreateJournal(
            user: Auth::user(),
            journalTemplate: $template,
            name: $data['name'],
        ))->execute();

        return new JournalResource($journal);
    }

    public function show(Request $request): JsonResource
    {
        $journal = $request->attributes->get('journal');

        return new JournalResource($journal);
    }

    public function update(Request $request): JsonResource
    {
        $journal = $request->attributes->get('journal');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'journal_template_id' => ['nullable', 'exists:journal_templates,id'],
        ]);

        $template = null;
        if (array_key_exists('journal_template_id', $data) && $data['journal_template_id']) {
            $template = JournalTemplate::where('account_id', Auth::user()->account_id)
                ->findOrFail($data['journal_template_id']);
        }

        $journal = (new UpdateJournal(
            user: Auth::user(),
            journal: $journal,
            journalTemplate: $template,
            name: $data['name'],
        ))->execute();

        return new JournalResource($journal);
    }

    public function destroy(Request $request): Response
    {
        $journal = $request->attributes->get('journal');

        (new DestroyJournal(
            user: Auth::user(),
            journal: $journal,
        ))->execute();

        return response()->noContent();
    }
}
