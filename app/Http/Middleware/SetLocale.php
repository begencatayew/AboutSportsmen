<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route()?->parameter('locale');

        if (in_array($locale, ['en', 'tr', 'ru'], true)) {
            app()->setLocale($locale);
            session()->put('locale', $locale);

            return $next($request);
        }

        $locale = session('locale', config('app.locale'));

        if (! in_array($locale, ['en', 'tr', 'ru'], true)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return $next($request);
    }
}
