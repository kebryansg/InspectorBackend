<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CorsMiddleware
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

        $possibleOrigins = [
            '*',
            'http://localhost',
            'http://localhost:4200',
            'http://localhost:8100'
        ];

        $origin = '*';
        $AllowHeader = '*';
        $AllowMethods = '*';
        if (false) {
//        if (in_array($request->header('origin'), $possibleOrigins)) {
            $AllowHeader = 'Content-Type, Accept, Authorization, X-Requested-With, Application';
            $AllowMethods = 'GET, PUT, POST, DELETE, HEAD';
        }

        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => $AllowMethods,
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers' => $AllowHeader,
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Access-Control-Allow-Methods', $AllowMethods);
        $response->headers->set('Access-Control-Allow-Headers', $AllowHeader);


        return $response;

//        foreach ($headers as $key => $value) {
//            $response->header($key, $value);
//        }
//
//        return $response;

    }
}
