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
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::guard()->check() && $request->routeIs('admin*')) {
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        if (Auth::guard('customer')->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
