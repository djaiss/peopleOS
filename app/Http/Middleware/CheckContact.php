<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use App\Models\Vault;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CheckContact
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $vault = $request->attributes->get('vault');
        $slug = $request->route()->parameter('slug');
        $id = (int) Str::before($slug, '-');

        try {
            $contact = Contact::where('vault_id', $vault->id)
                ->findOrFail($id);

            $request->attributes->add(['contact' => $contact]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
