<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PersonNoteController extends Controller
{
    public function index(): View
    {
        return view('persons.notes.index');
    }
}
