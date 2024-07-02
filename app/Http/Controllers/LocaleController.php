<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function update(string $locale): RedirectResponse
    {
        if (! in_array($locale, ['en', 'fr'])) {
            abort(400);
        }

        session('current_locale', $locale);

        return back();
    }
}
