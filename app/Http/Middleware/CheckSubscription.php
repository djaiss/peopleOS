<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * We need to block access if
     * - the paid version is enabled
     * - the user does not have lifetime access
     * - the user has an account for more than 30 days
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->account->needsToPay()) {
            return redirect()->route('upgrade.index');
        }

        return $next($request);
    }
}
