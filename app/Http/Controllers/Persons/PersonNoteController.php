<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Cache\PeopleListCache;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonNoteController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = PeopleListCache::make(
            accountId: Auth::user()->account_id,
        )->value();

        $notes = Note::where('person_id', $person->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Note $note): array => [
                'id' => $note->id,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M j, Y'),
                'is_new' => false,
            ]);

        return view('persons.notes.index', [
            'notes' => $notes,
            'persons' => $persons,
            'person' => $person,
        ]);
    }
}
