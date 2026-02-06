<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Lead;
use App\Models\SiteStat;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = SiteStat::where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get();

        $leadsCount = Lead::count();
        $leadsToday = Lead::whereDate('created_at', Carbon::today())->count();

        // Calculate abandoned forms (sessions with form_start but no lead created)
        // This is a simplified approximation.
        $formStarts = AnalyticsEvent::where('event_type', 'form_start')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Assuming every form_start should result in a lead (naïve but works for now)
        // A better way would be matching session_ids if we tracked session_id on Lead creation.
        // For now: Abandoned = Form Starts - Leads Created (in same period).
        // If Leads > Starts (e.g. manual entry or no telemetry), clamp to 0.
        $recentLeads = Lead::where('created_at', '>=', now()->subDays(30))->count();
        $abandonedForms = max(0, $formStarts - $recentLeads);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'leads_count' => $leadsCount,
            'leads_today' => $leadsToday,
            'abandoned_forms' => $abandonedForms,
        ]);
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'events' => 'required|array',
            'events.*.type' => 'required|string',
            'events.*.payload' => 'nullable|array',
        ]);

        foreach ($validated['events'] as $event) {
            AnalyticsEvent::create([
                'session_id' => $validated['session_id'],
                'event_type' => $event['type'],
                'payload' => $event['payload'] ?? null,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
