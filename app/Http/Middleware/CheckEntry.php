<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Journal;
use App\Services\CreateOrRetrieveEntry;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEntry
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $day = (int) $request->route()->parameter('day');
        $month = (int) $request->route()->parameter('month');
        $year = (int) $request->route()->parameter('year');

        try {
            $journal = Journal::where('account_id', Auth::user()->account_id)
                ->first();

            $entry = (new CreateOrRetrieveEntry(
                user: Auth::user(),
                journal: $journal,
                day: $day,
                month: $month,
                year: $year,
            ))->execute();
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['entry' => $entry]);

        return $next($request);
    }
}
