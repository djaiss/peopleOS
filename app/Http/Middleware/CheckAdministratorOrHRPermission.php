<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdministratorOrHRPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->permission !== Permission::ADMINISTRATOR->value &&
            Auth::user()->permission !== Permission::HR->value) {
            abort(403);
        }

        return $next($request);
    }
}
