<?php

namespace App\Http\Middleware;

use Closure;

class Seen
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            $request->user()->see();
        }

        return $next($request);
    }
}
