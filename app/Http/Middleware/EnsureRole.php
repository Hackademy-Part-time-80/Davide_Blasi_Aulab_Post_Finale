<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    // Uso nelle rotte: ->middleware('role:Admin') oppure ->middleware('role:Revisor,Admin')
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        abort_unless($request->user()?->hasRole(...$roles), 403);

        return $next($request);
    }
}
