<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function __construct()
    {
        // Simple authorization - check if user is a school admin
        // $this->middleware('can:school-access'); 
        // For more robust control, create a Policy: php artisan make:policy SubjectPolicy --model=Subject
        // Then use: $this->authorizeResource(Subject::class, 'subject');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Fetch subjects, likely filtering by the current school's level later
        // For now, get all subjects, eager load the level relationship
        $subjects = Subject::with('levels')->latest()->get(); 

        return view('school.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
       /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $levels = Level::all();
        // We pass levels to the view to allow selecting multiple
        return view('school.subjects.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate subject data (name, code) - no level_id here
        $validatedSubjectData = $request->validate([
            'subject_name' => 'required|string|max:100|unique:subjects,subject_name',
            'short_name' => 'nullable|string|max:20',
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code',
            'level_ids' => 'required|array', // Now we expect an array of level IDs
            'level_ids.*' => 'exists:levels,level_id', // Validate each level ID exists
        ]);

        // Create the subject first
        $subject = Subject::create([
            'subject_name' => $validatedSubjectData['subject_name'],
            'short_name' => $validatedSubjectData['short_name'],
            'subject_code' => $validatedSubjectData['subject_code'],
        ]);

        // Now attach the selected levels to the subject
        // This inserts records into the level_subject pivot table
        $subject->levels()->attach($validatedSubjectData['level_ids']);

        return redirect()->route('school.subjects.index')
                         ->with('success', 'Subject created successfully for the selected levels.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject): View
    {
        $levels = Level::all();
        // Get the IDs of the levels already attached to this subject
        $currentLevelIds = $subject->levels->pluck('level_id')->toArray();

        return view('school.subjects.edit', compact('subject', 'levels', 'currentLevelIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject): RedirectResponse
    {
        // Validate - use ignore rule for unique fields on this subject
        $validatedSubjectData = $request->validate([
            'subject_name' => 'required|string|max:100|unique:subjects,subject_name,' . $subject->subject_id . ',subject_id',
            'short_name' => 'nullable|string|max:20',
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code,' . $subject->subject_id . ',subject_id',
            'level_ids' => 'required|array',
            'level_ids.*' => 'exists:levels,level_id',
        ]);

        // Update the basic subject info
        $subject->update([
            'subject_name' => $validatedSubjectData['subject_name'],
            'short_name' => $validatedSubjectData['short_name'],
            'subject_code' => $validatedSubjectData['subject_code'],
        ]);

        // Sync the levels: this adds new ones and removes unchecked ones
        $subject->levels()->sync($validatedSubjectData['level_ids']);

        return redirect()->route('school.subjects.index')
                         ->with('success', 'Subject updated successfully.');
    }
    /**
     * Validation rules. Use a method to avoid duplication.
     * @param  \App\Models\Subject|null  $subject
     * @return array
     */
    protected function rules(Subject $subject = null): array
    {
        // The base rules array
        $rules = [
            'subject_name' => 'required|string|max:100',
            'short_name' => 'nullable|string|max:20',
            'subject_code' => 'required|string|max:20',
            'level_id' => 'required|exists:levels,level_id',
        ];

        // For creation, subject_code must be unique in the table
        if (!$subject) {
            $rules['subject_code'] .= '|unique:subjects,subject_code';
        } 
        // For update, subject_code must be unique, ignoring the current subject's code
        else {
            $rules['subject_code'] .= '|unique:subjects,subject_code,' . $subject->subject_id . ',subject_id';
        }

        return $rules;
    }
    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): View
    {
        // If you need a detail view
        return view('school.subjects.show', compact('subject'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('school.subjects.index')
                         ->with('success', 'Subject deleted successfully.');
    }

   
}