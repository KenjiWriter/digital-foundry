<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CaseStudyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/CaseStudies/Index', [
            'caseStudies' => CaseStudy::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/CaseStudies/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_industry' => 'required|string|max:255',
            'challenge_summary' => 'required|string',
            'solution_summary' => 'required|string',
            'roi_stats' => 'nullable|array',
            'tech_stack' => 'nullable|array',
            'cover_image' => 'required|image|max:2048', // 2MB Max
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('case-studies', 'public');
            $validated['cover_image_path'] = $path;
        }

        CaseStudy::create($validated);

        return redirect()->route('admin.case-studies.index');
    }

    public function edit(CaseStudy $caseStudy)
    {
        return Inertia::render('Admin/CaseStudies/Form', [
            'caseStudy' => $caseStudy,
        ]);
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_industry' => 'required|string|max:255',
            'challenge_summary' => 'required|string',
            'solution_summary' => 'required|string',
            'roi_stats' => 'nullable|array',
            'tech_stack' => 'nullable|array',
            'cover_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($caseStudy->cover_image_path) {
                Storage::disk('public')->delete($caseStudy->cover_image_path);
            }
            $path = $request->file('cover_image')->store('case-studies', 'public');
            $validated['cover_image_path'] = $path;
        }

        $caseStudy->update($validated);

        return redirect()->route('admin.case-studies.index');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        if ($caseStudy->cover_image_path) {
            Storage::disk('public')->delete($caseStudy->cover_image_path);
        }
        $caseStudy->delete();

        return redirect()->route('admin.case-studies.index');
    }
}
