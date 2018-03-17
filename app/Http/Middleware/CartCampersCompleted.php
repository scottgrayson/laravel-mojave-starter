<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Helpers\CartHelper;

class CartCampersCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return redirect(route('login'));
        }

        $incompleteCampers = CartHelper::incompleteCampers();

        if (!$incompleteCampers->isEmpty()) {
            $message = 'Please complete registration for the following campers: ' . $incompleteCampers->implode('name', ', ');

            if ($request->expectsJson()) {
                abort(400, $message);
            }

            flash($message)
                ->important()
                ->error();

            return redirect(route('campers.index'));
        }

        return $next($request);
    }
}
