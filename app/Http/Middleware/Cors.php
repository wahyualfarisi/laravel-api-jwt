<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $response = $next($request);

        $headers = [
            'Access-Control-Allow-Origin'   => '*',
            'Access-Control-Allow-Methods' => 'GET,POST,OPTIONS',
      //      'Access-Control-Max-Age'       => 604800,
            'Access-Control-Allow-Headers' => 'X-Requested-With, Origin, X-Csrftoken, Accept, Authorization',
          ];
         return $response->withHeaders($headers);  
    }
}
