<?php

namespace App\Http\Middleware;

use Closure;

class ValidationRequestMiddleware
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
        // Pre-Middleware Action
        if ($request->isJson()) {
            $response = $next($request);
            // Post-Middleware Action
            return $response;
        }
        return response()->json(['error' => 'Content-Type Not valid'], 401);

    }
}
