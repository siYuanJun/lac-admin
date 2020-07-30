<?php

namespace App\Http\Middleware;

use Closure;

class AuthStudAdmin
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
        if (auth()->guard('studio')->check()) {
            return redirect('/stud/login');
        }

        return $next($request);
    }
}
