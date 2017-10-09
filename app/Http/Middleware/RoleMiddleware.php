<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission)
    {
        if (Auth::guest()) {
            return redirect(route('login'));
        }

        if (! $request->user()->hasRole($role)) {
            return redirect(route('home'));
        }

        if (! ($request->user()->hasPermissionTo($permission) || $request->user()->can($permission))) {
            return redirect(route('home'));
        }

        return $next($request);
    }
}
