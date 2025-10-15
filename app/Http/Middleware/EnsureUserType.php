<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware(['auth', 'usertype:admin']) or 'usertype:user,admin'
     */
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        $user = $request->user();

        if (!$user) {
            // Let the 'auth' middleware handle unauthenticated users normally,
            // but if it's used without 'auth', return 403.
            abort(Response::HTTP_FORBIDDEN);
        }

        $allowed = empty($types) ? [] : array_map('strtolower', $types);
        $current = strtolower((string) ($user->user_type ?? ''));

        if (!in_array($current, $allowed, true)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
