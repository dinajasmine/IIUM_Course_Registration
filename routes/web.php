<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ManualRegistrationController;
use App\Http\Controllers\AdminController;
<<<<<<< HEAD
use App\Http\Controllers\RegistrationController;

=======
use App\Http\Controllers\Admin\SubjectAssignmentController;
use App\Http\Controllers\AuthController;
>>>>>>> c9645901661f3d85a12d062af6d215c4533d03c4

//redirect to login page
Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

<<<<<<< HEAD
Route::get('/', function () {
    return redirect('/student/registration'); 
});
=======
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
>>>>>>> c9645901661f3d85a12d062af6d215c4533d03c4

// STUDENT ROUTES
Route::prefix('student') //->middleware(['auth'])
        ->group(function () {
        //dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

        //manual registration
        Route::get('/manual-registration', [ManualRegistrationController::class, 'create'])->name('student.manual-registration.create');
        Route::post('/manual-registration', [ManualRegistrationController::class, 'store'])->name('student.manual-register.store');
<<<<<<< HEAD
        //Route::get('/logout', [StudentController::class, 'logout'])->name('student.logout'); optional (kalau perlu buang //)
        Route::get('/registration', [RegistrationController::class, 'index'])->name('registration.index');
        Route::post('/registration/register', [RegistrationController::class, 'register'])->name('registration.register');
        Route::put('/registration/update-section/{registrationId}', [RegistrationController::class, 'updateSection'])->name('registration.update-section');
        Route::delete('/registration/drop/{registrationId}', [RegistrationController::class, 'drop'])->name('registration.drop');
        Route::get('/registration/sections/{subjectId}', [RegistrationController::class, 'getSections'])->name('registration.sections');
});

/*ADMIN ROUTES*/
Route::prefix('admin')->group(function () {
    //Route::middleware(['auth', 'role:admin'])->group(function () { --> bila dh ade login baru bukak 
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/manual-approval', [AdminController::class, 'manualApproval'])->name('admin.manual-approval');
        Route::post('/assign-subject', [AdminController::class, 'assignSubject'])->name('admin.assign-subject');
        Route::post('/manual-approval/{id}/approve', [AdminController::class, 'approve'])->name('admin.manual-approval.approve');
        Route::delete('/manual-approval/{id}/reject', [AdminController::class, 'reject'])->name('admin.manual-approval.reject');
        //Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout'); optional (kalau perlu buang //)
=======

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
>>>>>>> c9645901661f3d85a12d062af6d215c4533d03c4
});
