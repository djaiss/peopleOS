<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Jobs\LogLastPersonSeen;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Models\Person;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckPerson
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route()->parameter('slug');
        $id = (int) Str::before($slug, '-');

        try {
            $person = Person::where('account_id', Auth::user()->account_id)
                ->with('ageSpecialDate')
                ->findOrFail($id);

            $request->attributes->add(['person' => $person]);

            LogLastPersonSeen::dispatch(
                user: Auth::user(),
                person: $person
            )->onQueue('low');

            UpdatePersonLastConsultedDate::dispatch(
                person: $person
            )->onQueue('low');

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
