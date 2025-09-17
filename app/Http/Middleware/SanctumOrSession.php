<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanctumOrSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated via session, allow
        if ($request->user()) {
            return $next($request);
        }
        // Try Sanctum token guard
        if (auth('sanctum')->check()) {
            return $next($request);
        }
        // Otherwise redirect to login for web or 401 for API-ish requests
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
