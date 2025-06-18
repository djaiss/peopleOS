<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Pet;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPet
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = (int) $request->route()->parameter('pet');
        $person = $request->attributes->get('person');

        try {
            $pet = Pet::where('account_id', $person->account_id)->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['pet' => $pet]);

        return $next($request);
    }
}
