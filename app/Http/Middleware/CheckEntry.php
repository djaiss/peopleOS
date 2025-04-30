<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Note;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEntry
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $note = (int) $request->route()->parameter('note');
        $person = $request->attributes->get('person');

        try {
            $note = Note::where('person_id', $person->id)->findOrFail($note);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['note' => $note]);

        return $next($request);
    }
}
