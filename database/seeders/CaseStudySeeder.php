<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caseStudies = [
            [
                'title' => 'Fleet Management System',
                'client_industry' => 'Logistics',
                'cover_image_path' => 'https://placehold.co/600x400/1e293b/ffffff?text=Logistics',
                'challenge_summary' => 'Manual Excel routing was causing inefficiencies and delays.',
                'solution_summary' => 'Algorithm-based routing system with real-time tracking.',
                'roi_stats' => ['Fuel Saved' => '15%', 'Admin Hours' => '-20h/week'],
                'tech_stack' => ['Laravel', 'Vue', 'Google Maps API'],
                'is_published' => true,
            ],
            [
                'title' => 'B2B Wholesale Portal',
                'client_industry' => 'E-commerce',
                'cover_image_path' => 'https://placehold.co/600x400/1e293b/ffffff?text=E-commerce',
                'challenge_summary' => 'Phone orders causing errors data entry mistakes.',
                'solution_summary' => 'Self-service Vue dashboard with real-time inventory.',
                'roi_stats' => ['Order Errors' => '0%', 'Upsell Revenue' => '+25%'],
                'tech_stack' => ['Laravel', 'Inertia', 'Stripe'],
                'is_published' => true,
            ],
            [
                'title' => 'Patient Booking App',
                'client_industry' => 'Healthcare',
                'cover_image_path' => 'https://placehold.co/600x400/1e293b/ffffff?text=Healthcare',
                'challenge_summary' => 'High no-show rate impacting clinic revenue.',
                'solution_summary' => 'Automated SMS reminders and queue management system.',
                'roi_stats' => ['No-shows' => '-40%', 'Clinic Capacity' => '+15%'],
                'tech_stack' => ['Vue', 'Twilio', 'MySQL'],
                'is_published' => true,
            ],
        ];

        foreach ($caseStudies as $caseStudy) {
            \App\Models\CaseStudy::create($caseStudy);
        }
    }
}
