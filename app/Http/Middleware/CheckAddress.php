<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Address;
use App\Models\Pet;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = (int) $request->route()->parameter('address');
        $person = $request->attributes->get('person');

        try {
            $address = Address::where('account_id', $person->account_id)->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['address' => $address]);

        return $next($request);
    }
}
