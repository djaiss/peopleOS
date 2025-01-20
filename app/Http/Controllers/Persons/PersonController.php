<?php

declare(strict_types=1);

namespace App\Http\Controllers\Persons;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index(): View
    {
        return view('persons.index');
    }

    public function new(): View
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        return view('persons.new', [
            'genders' => $genders,
        ]);
    }

    public function store(): void
    {
        dd($this);
    }
}
