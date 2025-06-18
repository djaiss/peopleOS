<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Mood;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMood
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = (int) $request->route()->parameter('mood');
        $entry = $request->attributes->get('entry');

        try {
            $mood = Mood::where('entry_id', $entry->id)->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['mood' => $mood]);

        return $next($request);
    }
}
