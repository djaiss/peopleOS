<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTeamApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $team = (int) $request->route()->parameter('team');

        try {
            $team = Team::findOrFail($team);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        if (! Auth::user()->teams()->where('id', $team->id)->exists()) {
            abort(403);
        }

        $request->attributes->add(['team' => $team]);

        return $next($request);
    }
}
