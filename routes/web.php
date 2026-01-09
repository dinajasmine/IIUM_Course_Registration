<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ManualRegistrationController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login'); 
});

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);


/*STUDENT ROUTES*/
Route::prefix('student')->group(function () {
    //Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/manual-registration', [ManualRegistrationController::class, 'create'])->name('student.manual-registration');
        Route::post('/manual-registration', [ManualRegistrationController::class, 'store'])->name('student.manual-register.store');
        //Route::get('/logout', [StudentController::class, 'logout'])->name('student.logout'); optional (kalau perlu buang //)
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
