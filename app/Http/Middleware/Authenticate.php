<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->routeIs('admin*')) {
            return Auth::guard()->check() ? null : route('admin.login');
        }

        if ($request->routeIs('customer*')) {
            return Auth::guard()->check() ? null : route('customer.login');
        }

        return null;
    }
}
