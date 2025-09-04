<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\ExamController;
use App\Http\Controllers\School\MarkController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\EnsureIsAdmin;


// Redirect root to login
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->is_admin) {
            return redirect()->route('admin.schools.index');
        } elseif ($user->is_school_admin) {
            return redirect()->route('school.students.index');
        } else {
            return redirect()->route('school.marks.create');
        }
    })->name('dashboard');

    // Admin routes
    Route::middleware(['auth', EnsureIsAdmin::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Proper resource route for schools
            Route::resource('schools', SchoolController::class)->except(['show']);
            Route::put('/schools/{school}', [SchoolController::class, 'update'])
                ->name('admin.schools.update');
            Route::delete('/admin/schools/{school}', [SchoolController::class, 'destroy'])
                ->name('admin.schools.destroy');
            // Resource route for users
            Route::resource('users', UserController::class);
        });


    // School Admin routes
    Route::middleware('can:school_admin')->prefix('school')->name('school.')->group(function () {
        Route::resource('students', StudentController::class);
    });

    // Data Entry routes
    Route::middleware('can:data_entry')->prefix('data')->name('data.')->group(function () {
        Route::resource('marks', MarkController::class);
    });
});

require __DIR__ . '/auth.php';
