<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'pl', 'es', 'ru'];

        // 1. Check Session
        if (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            App::setLocale(Session::get('locale'));
        }
        // 2. Check Browser Header (Auto-detect only if no session set)
        else {
            $browserLocale = $request->getPreferredLanguage($supportedLocales);
            // getPreferredLanguage can return null or a match.
            // If null, we default to config('app.locale') which is usually 'en'.

            if ($browserLocale) {
                App::setLocale($browserLocale);
            }
        }

        return $next($request);
    }
}
