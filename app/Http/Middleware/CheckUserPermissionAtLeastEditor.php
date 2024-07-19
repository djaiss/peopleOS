<?php

namespace App\Http\Middleware;

use App\Models\Vault;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermissionAtLeastEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permission = $request->attributes->get('permission');

        if ($permission > Vault::PERMISSION_EDIT) {
            abort(401);
        }

        return $next($request);
    }
}
