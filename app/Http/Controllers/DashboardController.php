<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\ExamResult;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        
        if ($user->is_admin) {
            return $this->adminDashboard();
        } elseif ($user->is_school_admin) {
            return $this->schoolAdminDashboard();
        } elseif ($user->is_data_entry) {
            return $this->dataEntryDashboard();
        }
        
        return view('dashboard.guest');
    }

    protected function adminDashboard()
    {
        $stats = [
            'total_schools' => \App\Models\School::count(),
            'total_users' => \App\Models\User::count(),
            'active_schools' => \App\Models\School::where('is_active', true)->count(),
        ];
            return view('dashboard.admin', compact('stats'));
    }

    protected function schoolAdminDashboard()
    {
        // Get school associated with this admin
        $school = auth()->user()->school;
        
        $stats = [
            'total_students'  => \App\Models\Student::count(),
            'total_subjects'  => \App\Models\Subject::count(),
            'recent_exams'  => \App\Models\Exam::latest()->take(5)->get(),
            'marks_entered' => \App\Models\ExamResult::count(),
    ];
        return view('dashboard.school-admin', compact('stats', 'school'));
    }

    protected function dataEntryDashboard()
    {
        return view('dashboard.data-entry', [
            'pending_marks' => \App\Models\ExamResult::where('entered_by', auth()->id())
                ->where('created_at', '>=', now()->subDays(7))
                ->count()
        ]);
    }
}