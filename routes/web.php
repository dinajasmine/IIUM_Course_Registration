<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ManualRegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SubjectAssignmentController;
use App\Http\Controllers\AuthController;

//redirect to login page
Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// STUDENT ROUTES
Route::prefix('student') //->middleware(['auth'])
        ->group(function () {
        //dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

        //manual registration
        Route::get('/manual-registration', [ManualRegistrationController::class, 'create'])->name('student.manual-registration.create');
        Route::post('/manual-registration', [ManualRegistrationController::class, 'store'])->name('student.manual-register.store');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ADMIN ROUTES
Route::prefix('admin') //->middleware(['auth', 'user_type:ADMIN'])
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/manual-approval', [AdminController::class, 'manualApproval'])
        ->name('admin.manual-approval');

    Route::post('/manual-approval/{id}/approve', [AdminController::class, 'approve'])
        ->name('admin.manual-approval.approve');

    Route::delete('/manual-approval/{id}/reject', [AdminController::class, 'reject'])
        ->name('admin.manual-approval.reject');

    // Subject Assignment Management
    Route::get('/subject-assignment', [SubjectAssignmentController::class, 'index'])
        ->name('admin.subject.assignment');

    Route::post('/subject-assignment', [SubjectAssignmentController::class, 'store'])
        ->name('admin.subject.assignment.store');
});
