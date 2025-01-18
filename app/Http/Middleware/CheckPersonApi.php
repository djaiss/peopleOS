<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPersonApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $person = (int) $request->route()->parameter('person');

        try {
            $person = Person::where('account_id', Auth::user()->account_id)
                ->findOrFail($person);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['person' => $person]);

        return $next($request);
    }
}
