<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**

     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param string $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->roles->contains('name', 'admin')) {
            return $next($request);
        }

        if ($request->user()->roles->isEmpty()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        if (!$request->user()->roles->contains('name', $role)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        return $next($request);
    }
}
