<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->role?->name === 'Admin', 403);
        return $next($request);
    }
}