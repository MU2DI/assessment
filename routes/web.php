<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\ExamController;
use App\Http\Controllers\School\MarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsSchoolAdmin;
use App\Http\Middleware\EnsureIsDataEntry;

// Redirect to login with option to go to dashboard if already logged in
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('auth.login');
})->name('home');

// Authentication routes
require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // Unified dashboard with role-based content
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware([EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('schools', SchoolController::class);
        Route::resource('users', UserController::class);
    });

    // School Admin routes
    Route::middleware([EnsureIsSchoolAdmin::class])->prefix('school')->name('school.')->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('exams', ExamController::class);
        Route::get('exams/assign', [ExamController::class, 'assign'])
            ->name('school.exams.assign');

        Route::post('exams/assign', [ExamController::class, 'assignStore'])
            ->name('school.exams.assign.assignstore');
    });

    // Data Entry routes
    Route::middleware([EnsureIsDataEntry::class])->prefix('data')->name('data.')->group(function () {
        Route::resource('marks', MarkController::class);
    });

    // Reports (accessible to all authenticated users)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('rankings', [ReportController::class, 'rankings'])->name('rankings');
        Route::get('school-performance', [ReportController::class, 'schoolPerformance'])->name('school-performance');
    });
});
