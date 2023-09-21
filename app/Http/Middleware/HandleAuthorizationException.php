<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class HandleAuthorizationException
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() === Response::HTTP_FORBIDDEN) {
            // Replace the default HTML response with a JSON response
            return response()->json(['message' => ['error' => ['Access forbidden']]], Response::HTTP_FORBIDDEN);

        }

        return $response;
    }
}
