<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Use default guard if no guards are specified
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect admin users to the admin dashboard
                if ($guard === 'admin') {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                // Redirect default users to the defined HOME route
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Allow unauthenticated requests to proceed
        return $next($request);
    }
}
