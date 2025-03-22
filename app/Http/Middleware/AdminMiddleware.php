<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to restrict access to admin users only
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is an admin
        if (!$request->user() || !$request->user()->is_admin) {
            // Redirect to login page with error message
            return redirect()->route('login')
                ->with('error', 'You need administrator privileges to access this area.');
        }

        return $next($request);
    }
}