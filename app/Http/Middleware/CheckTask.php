<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTask
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task = (int) $request->route()->parameter('task');
        $person = $request->attributes->get('person');

        try {
            $task = Task::where('person_id', $person->id)
                ->with('taskCategory')
                ->findOrFail($task);
        } catch (ModelNotFoundException) {
            abort(404);
        }

        $request->attributes->add(['task' => $task]);

        return $next($request);
    }
}
