<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            // if user is not admin take him to his dashboard
            if (!$user->Admin()) {
                abort(403);
            }

            // allow admin to proceed with request
            else {
                return $next($request);
            }
        }

        // permission denied error
    }
}
