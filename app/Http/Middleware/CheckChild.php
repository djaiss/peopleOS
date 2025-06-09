<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Child;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckChild
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $childId = $request->route()->parameter('child');

        try {
            $child = Child::where('account_id', Auth::user()->account_id)
                ->with('parent', 'secondParent')
                ->findOrFail($childId);

            $request->attributes->add(['child' => $child]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
