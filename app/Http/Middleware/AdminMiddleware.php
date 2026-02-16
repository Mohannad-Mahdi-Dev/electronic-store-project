<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || $user->role_id != 1) {
            abort(403, 'ليس لديك صلاحية الدخول');
        }

        return $next($request);
    }
}
