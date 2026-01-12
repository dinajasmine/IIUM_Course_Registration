<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ManualRegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SubjectAssignmentController;
use App\Http\Controllers\AuthController;

// Default redirect
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login'); 
});

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
>>>>>>> Stashed changes

/*STUDENT ROUTES*/
Route::prefix('student')->group(function () {
    //Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/manual-registration', [StudentController::class, 'manual'])->name('student.manual-registration');
        Route::post('/manual-registration', [StudentController::class, 'storeManual'])->name('student.manual-register.store');
        //Route::get('/logout', [StudentController::class, 'logout'])->name('student.logout'); optional (kalau perlu buang //)
});


/*ADMIN ROUTES*/
Route::prefix('admin')->group(function () {

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
