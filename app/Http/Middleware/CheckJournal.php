<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Journal;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJournal
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $journal = (int) $request->route()->parameter('journal');

        try {
            $journal = Journal::where('account_id', $request->user()->account_id)->findOrFail($journal);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['journal' => $journal]);

        return $next($request);
    }
}
