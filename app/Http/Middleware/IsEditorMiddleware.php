<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEditorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // IsAdminMiddleware.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'editor') {
            return $next($request);
        }

        return abort(403, 'Unauthorized');
    }

}
