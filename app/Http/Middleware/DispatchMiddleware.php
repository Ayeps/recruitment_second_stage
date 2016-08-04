<?php

namespace App\Http\Middleware;

use Closure;

class DispatchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role != 2) {
            flash('Not allowed');
            return redirect('1');
        }

        return $next($request);
    }
}
