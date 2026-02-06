<?php

namespace App\Http\Middleware;

use App\Models\SiteStat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip analytics for API/Assets/Admin if needed
        if ($request->is('admin*') || $request->is('api*') || $request->is('_debugbar*')) {
            return $next($request);
        }

        $today = now()->format('Y-m-d');
        $ip = $request->ip();
        $cacheKey = "visited_today_{$ip}";

        // Prepare stat record (firstOrCreate ensures we have a row for today)
        $stat = SiteStat::firstOrCreate(
            ['date' => $today],
            ['visits' => 0, 'page_views' => 0, 'total_duration' => 0]
        );

        $stat->increment('page_views');

        if (!Cache::has($cacheKey)) {
            $stat->increment('visits');
            // Cache until end of day
            Cache::put($cacheKey, true, now()->endOfDay());
        }

        return $next($request);
    }
}
