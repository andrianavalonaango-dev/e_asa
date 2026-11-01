<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            app()->setLocale(\Illuminate\Support\Facades\Auth::user()->locale ?? 'fr');
        } else {
            app()->setLocale('fr');
        }

        return $next($request);
    }
}
