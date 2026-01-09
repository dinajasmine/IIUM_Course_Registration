<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login'); 
});

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

Route::get('/', function () {
    return redirect('/student/registration'); 
});

/*STUDENT ROUTES*/
Route::prefix('student')->group(function () {
    //Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/manual-registration', [StudentController::class, 'manual'])->name('student.manual-registration');
        Route::post('/manual-registration', [StudentController::class, 'storeManual'])->name('student.manual-register.store');
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
});
