<?php

namespace App\Http\Middleware;

use App\Helpers\Common;
use Closure;

class XssMiddelware
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
        Common::globalXssClean();
        return $next($request);
    }
}
