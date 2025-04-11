<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\LifeEvent;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLifeEvent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lifeEvent = (int) $request->route()->parameter('lifeEvent');
        $person = $request->attributes->get('person');

        try {
            $lifeEvent = LifeEvent::where('person_id', $person->id)
                ->findOrFail($lifeEvent);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['lifeEvent' => $lifeEvent]);

        return $next($request);
    }
}
