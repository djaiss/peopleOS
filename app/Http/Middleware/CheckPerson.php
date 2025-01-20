<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Person;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckPerson
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route()->parameter('slug');
        $id = (int) Str::before($slug, '-');

        try {
            $person = Person::where('account_id', Auth::user()->account_id)
                ->findOrFail($id);

            $request->attributes->add(['person' => $person]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
