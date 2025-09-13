<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Events\ActivityLogged;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        event(new ActivityLogged($request->user()->id, $request->route()->getName()));
        return $next($request);
    }
}
