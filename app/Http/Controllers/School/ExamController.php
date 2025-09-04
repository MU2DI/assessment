<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Level;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{

    public function index()
    {
        $exams = Exam::with('level')->latest()->get();
        return view('school.exams.index', compact('exams'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('school.exams.create', compact('levels'));
    }

    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:100',
            'academic_year' => 'required|string|max:10',
            'term' => 'nullable|string|max:50',
            'level_id' => 'required|exists:levels,level_id',

            // Prevent duplicates based on combination
            Rule::unique('exams')->where(function ($query) use ($request) {
                return $query->where('exam_name', $request->exam_name)
                    ->where('academic_year', $request->academic_year)
                    ->where('level_id', $request->level_id);
            })->ignore($exam->exam_id, 'exam_id'),
        ]);

        Exam::create($validated);

        return redirect()->route('school.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        $levels = Level::all();
        return view('school.exams.edit', compact('exam', 'levels'));
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $$exam);
        return view('school.exams.show', compact('exam'));
    }
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:100',
            'academic_year' => 'required|string|max:10',
            'term' => 'nullable|string|max:50',
            'level_id' => 'required|exists:levels,level_id',

            Rule::unique('exams')->where(function ($query) use ($request) {
                return $query->where('exam_name', $request->exam_name)
                    ->where('academic_year', $request->academic_year)
                    ->where('level_id', $request->level_id);
            })->ignore($exam->exam_id, 'exam_id'),
        ]);

        $exam->update($validated);

        return redirect()->route('school.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('school.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
    /**
     * Show assign form for a specific exam.
     */
    public function assign(Request $request)
    {
        $levelId = $request->query('level');
    $year    = $request->query('year');

    $students = collect();
    $exams    = collect();

    if ($levelId && $year) {
        $students = Student::with('level')
            ->where('level_id', $levelId)
            ->where('academic_year', $year)
            ->where('is_active', 1)
            ->get();

        $exams = Exam::where('level_id', $levelId)
            ->where('academic_year', $year)
            ->get();
    }

    return view('school.exams.assign', compact('students', 'exams', 'levelId', 'year'));
    }

    public function assignStore(Request $request)
    {
        $data = $request->validate([
            'exam_id'      => 'required|exists:exams,exam_id',
            'student_ids'  => 'required|array',
            'student_ids.*' => 'exists:students,student_id',
        ]);

        // attach students to the exam (create ExamMark shells if that’s your pivot)
        foreach ($data['student_ids'] as $studentId) {
            ExamResult::firstOrCreate([
                'exam_id'    => $data['exam_id'],
                'student_id' => $studentId,
            ]);
        }

        return redirect()
            ->route('school.students.index', request()->only('level', 'year', 'status')) // keep filters
            ->with('success', 'Students assigned to exam successfully.');
    }
}
