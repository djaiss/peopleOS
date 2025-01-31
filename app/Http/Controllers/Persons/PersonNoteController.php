<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonNoteController extends Controller
{
    public function index(Request $request): View
    {
        $person = $request->attributes->get('person');

        $persons = Person::where('account_id', Auth::user()->account_id)
            ->where('is_listed', true)
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ])
            ->sortBy('name');

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
