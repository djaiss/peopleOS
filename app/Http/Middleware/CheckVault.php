<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVault
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('vault'))) {
            $id = (int) $request->route()->parameter('vault');
        } else {
            $id = $request->route()->parameter('vault')->id;
        }

        try {
            $vault = auth()->user()
                ->vaults()
                ->where('account_id', auth()->user()->account_id)
                ->findOrFail($id);

            $request->attributes->add(['permission' => $vault->pivot->permission]);
            $request->attributes->add(['vault' => $vault]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
