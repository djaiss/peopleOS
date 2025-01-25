<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\WorkHistory;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workHistory = (int) $request->route()->parameter('entry');
        $person = $request->attributes->get('person');

        try {
            $workHistory = WorkHistory::where('person_id', $person->id)->findOrFail($workHistory);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['workHistory' => $workHistory]);

        return $next($request);
    }
}
