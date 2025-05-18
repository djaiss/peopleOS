<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\LoveRelationship;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoveRelationship
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = (int) $request->route()->parameter('loveRelationship');
        $person = $request->attributes->get('person');

        try {
            $loveRelationship = LoveRelationship::where(function ($query) use ($person): void {
                $query->where('person_id', $person->id)
                    ->orWhere('related_person_id', $person->id);
            })->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['loveRelationship' => $loveRelationship]);

        return $next($request);
    }
}
