<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        /*
        Three judgments:
         1. If the user is already logged in
         2. And not yet certified Email
         3. And not accessing the email verification URL or the exit URL.
        */
        if ($request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*', 'logout')) {

            // Return the corresponding content according to the client
            return $request->expectsJson()
                        ? abort(403, 'Your email address is nor verified.')
                        : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
