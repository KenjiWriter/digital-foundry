<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Inertia\Inertia;
use Inertia\Response;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('CaseStudies/Index', [
            'caseStudies' => CaseStudy::where('is_published', true)
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CaseStudy $caseStudy): Response
    {
        if (!$caseStudy->is_published) {
            abort(404);
        }

        return Inertia::render('CaseStudies/Show', [
            'caseStudy' => $caseStudy,
        ]);
    }
}
