<?php

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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $vault = $request->attributes->get('vault');
        $id = $request->route()->parameter('journal');

        try {
            $journal = Journal::where('vault_id', $vault->id)
                ->findOrFail($id);

            $request->attributes->add(['journal' => $journal]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
