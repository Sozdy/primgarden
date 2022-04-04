<?php

namespace App\Http\Middleware;

use Closure;

class Middleware1c
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
        if (strtolower($request->user()->email) != "1c@primgarden.ru")
            return Response("Get outta here, get outta here, maaan", 403);

        return $next($request);
    }
}
