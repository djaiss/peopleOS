<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMarketingSiteEnabled
{
    /**
     * Check that the marketing site is enabled in the environment variable.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('peopleos.show_marketing_site')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
