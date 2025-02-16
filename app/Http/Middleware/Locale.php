<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = "ar";

        if ($request->header('Locale')) {
            if (in_array($request->header('Locale'), ['ar', 'en'])) {
                $locale = $request->header('Locale');
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
