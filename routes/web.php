<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student/manual-registration', [StudentController::class, 'manual']);
Route::post('/student/manual-registration', [StudentController::class, 'storeManual']);

Route::get('/admin/manual-approval', [AdminController::class, 'manualApproval']);
Route::post('/admin/manual-approval/{id}', [AdminController::class, 'approve']);