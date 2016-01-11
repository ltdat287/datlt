<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class CheckRequestParam
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
        if (isset($request)) {
            $param_request = json_encode($request->all());
            //Log::error($param_request);
        }
        return $next($request);
    }
}
