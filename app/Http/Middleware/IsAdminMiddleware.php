<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // IsAdminMiddleware.php
    public function handle($request, Closure $next)
    {
       // return auth();
        //return new JsonResponse(['message' => auth()->check(),'condition'=> auth()->user()->role], 403);
        if (auth()->check() && auth()->user()->role ==='admin') {
            return $next($request);
        }

        return new JsonResponse(['message' => 'Unauthorized'], 403);
    }

}
