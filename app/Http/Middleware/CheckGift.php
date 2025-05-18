<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Gift;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGift
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = (int) $request->route()->parameter('gift');
        $person = $request->attributes->get('person');

        try {
            $gift = Gift::where('person_id', $person->id)->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['gift' => $gift]);

        return $next($request);
    }
}
