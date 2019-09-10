<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If it is a logged in user
        if (Auth::check()) {
            // Record the last login time
            Auth::user()->RecordLastActivedAt();
        }

        return $next($request);
    }
}
