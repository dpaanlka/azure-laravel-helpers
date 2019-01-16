<?php

namespace App\Http\Middleware;

use Closure;

class AzureCDN
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

        // Azure CDN uses non-standard X_HOST header, rather than the standard X_FORWARDED_HOST that Laravel is expecting.
        // Here we check if X_HOST exists in the request header, and if so set X_FORWARDED_HOST with same value.
        $azure_x_host = $request->headers->get('X_HOST');
        if (!empty($azure_x_host)) {
            $request->headers->set('X_FORWARDED_HOST', $azure_x_host);
        }

        return $next($request);

    }
}
