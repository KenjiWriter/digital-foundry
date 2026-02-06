<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::withCount('questions')->get();

        return Inertia::render('Admin/Sectors/Index', [
            'sectors' => $sectors,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Sectors/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.pl' => 'required|string',
            'icon' => 'required|string',
            'is_active' => 'boolean',
            'questions' => 'present|array',
            'questions.*.question_text.en' => 'required|string',
            'questions.*.question_text.pl' => 'required|string',
            'questions.*.variable_name' => 'required|string',
            'questions.*.cost_per_unit' => 'required|numeric',
            'questions.*.suggestion_text.en' => 'required|string',
            'questions.*.suggestion_text.pl' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $sector = Sector::create([
                'name' => $validated['name'],
                'icon' => $validated['icon'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            foreach ($validated['questions'] as $questionData) {
                $sector->questions()->create($questionData);
            }
        });

        return redirect()->route('admin.sectors.index')->with('success', 'Sector created successfully.');
    }

    public function edit(Sector $sector)
    {
        $sector->load('questions');
        return Inertia::render('Admin/Sectors/Form', [
            'sector' => $sector,
        ]);
    }

    public function update(Request $request, Sector $sector)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.pl' => 'required|string',
            'icon' => 'required|string',
            'is_active' => 'boolean',
            'questions' => 'present|array',
            'questions.*.id' => 'nullable|integer|exists:audit_questions,id',
            'questions.*.question_text.en' => 'required|string',
            'questions.*.question_text.pl' => 'required|string',
            'questions.*.variable_name' => 'required|string',
            'questions.*.cost_per_unit' => 'required|numeric',
            'questions.*.suggestion_text.en' => 'required|string',
            'questions.*.suggestion_text.pl' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $sector) {
            $sector->update([
                'name' => $validated['name'],
                'icon' => $validated['icon'],
                'is_active' => $validated['is_active'],
            ]);

            // Sync Questions
            $inputQuestions = collect($validated['questions']);
            $existingQuestionIds = $inputQuestions->pluck('id')->filter();

            // Delete removed questions
            $sector->questions()->whereNotIn('id', $existingQuestionIds)->delete();

            // Update or Create
            foreach ($inputQuestions as $qData) {
                if (isset($qData['id'])) {
                    $sector->questions()->where('id', $qData['id'])->update([
                        'question_text' => $qData['question_text'],
                        'variable_name' => $qData['variable_name'],
                        'cost_per_unit' => $qData['cost_per_unit'],
                        'suggestion_text' => $qData['suggestion_text'],
                    ]);
                } else {
                    $sector->questions()->create($qData);
                }
            }
        });

        return redirect()->route('admin.sectors.index')->with('success', 'Sector updated successfully.');
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return redirect()->route('admin.sectors.index')->with('success', 'Sector deleted successfully.');
    }
}
