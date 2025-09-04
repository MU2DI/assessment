<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Level;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{


    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->center_code) {
            return redirect()->route('dashboard')
                ->with('error', 'No school assigned to your account.');
        }

        // Get filter parameters from request
        $levelFilter = $request->input('level');
        $yearFilter = $request->input('year');
        $statusFilter = $request->input('status');

        // Start query
        $query = Student::where('center_code', $user->center_code)
            ->with('level');

        // Apply level filter
        if ($levelFilter) {
            $query->where('level_id', $levelFilter);
        }

        // Apply academic year filter
        if ($yearFilter) {
            $query->where('academic_year', $yearFilter);
        }

        // Apply status filter
        if ($statusFilter !== null) {
            $query->where('is_active', $statusFilter);
        }

        $students = $query
            ->orderBy('gender')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(20);


        // Get available levels for filter dropdown
        $levels = Level::whereHas('schools', function ($query) use ($user) {
            $query->where('center_code', $user->center_code);
        })->get();

        // Get unique academic years for filter dropdown
        $academicYears = Student::where('center_code', $user->center_code)
            ->distinct()
            ->pluck('academic_year')
            ->sortDesc();

        return view('school.students.index', compact('students', 'levels', 'academicYears'))
            ->with('page_title', 'Student Management')
            ->with('breadcrumb', 'Students');
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user->center_code) {
            return redirect()->route('school.students.index')
                ->with('error', 'No school assigned to your account.');
        }

        $levels = Level::whereHas('schools', function ($query) use ($user) {
            $query->where('center_code', $user->center_code);
        })->get();

        // Get only current and previous year as single values
        $currentYear = now()->year;
        $academicYears = [
            $currentYear => $currentYear . ' (Current Year)',
            $currentYear - 1 => ($currentYear - 1) . ' (Previous Year)'
        ];

        return view('school.students.create', compact('levels', 'academicYears'));
    }
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->center_code) {
            return redirect()->route('school.students.index')
                ->with('error', 'No school assigned to your account.');
        }

        $currentYear = now()->year;
        $validYears = [$currentYear, $currentYear - 1]; // Only 2025 and 2024

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:M,F,O',
            'dob' => 'required|date|before:today',
            'level_id' => 'required|exists:levels,level_id',
            'academic_year' => 'required|integer|in:' . implode(',', $validYears)
        ]);

        // Check for duplicate student within the same school
        $duplicate = Student::where('first_name', $validated['first_name'])
            ->where('last_name', $validated['last_name'])
            ->where('dob', $validated['dob'])
            ->where('level_id', $validated['level_id'])
            ->where('center_code', $user->center_code) // Check within same school
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['duplicate' => 'Student with same name and DOB already exists in this level.']);
        }

        // Automatically use the school admin's center_code
        Student::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'level_id' => $validated['level_id'],
            'academic_year' => $validated['academic_year'],
            'center_code' => $user->center_code
        ]);

        return redirect()->route('school.students.index')
            ->with('success', 'Student registered successfully!');
    }
    public function show(Student $student)
    {
        $this->authorize('view', $student);
        return view('school.students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        // Manual authorization check
        if ($student->center_code !== auth()->user()->center_code) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $levels = Level::whereHas('schools', function ($query) use ($user) {
            $query->where('center_code', $user->center_code);
        })->get();

        return view('school.students.edit', compact('student', 'levels'));
    }


    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Manual authorization check
        if ($student->center_code !== auth()->user()->center_code) {
            abort(403, 'Unauthorized action.');
        }

        $currentYear = now()->year;
        $validYears = [$currentYear, $currentYear - 1];

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:M,F,O',
            'dob' => 'required|date|before:today',
            'level_id' => 'required|exists:levels,level_id',
            'academic_year' => 'required|integer|in:' . implode(',', $validYears),
            'is_active' => 'sometimes|boolean'
        ]);

        $student->update($validated);

        return redirect()->route('school.students.index')
            ->with('success', 'Student updated successfully!');
    }
    public function destroy(Student $student)
    {

        $student->delete();

        return redirect()->route('school.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
