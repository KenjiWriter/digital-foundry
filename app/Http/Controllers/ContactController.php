<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // For now until mail is setup

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|string|max:255',
            'pain_point' => 'required|string',
        ]);

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'message' => $validated['pain_point'], // Mapping pain_point to message
            'ip_address' => $request->ip(),
        ]);

        // TODO: Send Email Notification
        // Mail::to(config('mail.admin_address'))->send(new LeadReceived($lead));

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
