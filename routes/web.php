<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ManualRegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SubjectAssignmentController;


Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

// STUDENT ROUTES
Route::prefix('student')->middleware(['auth'])->group(function () {
        //dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/timetable', [StudentController::class, 'timetable'])->name('student.timetable');

        //manual registration
        Route::get('/manual-registration', [ManualRegistrationController::class, 'create'])->name('student.manual-registration.create');
        Route::post('/manual-registration', [ManualRegistrationController::class, 'store'])->name('student.manual-register.store');

        
        
        Route::get('/registration', [CourseRegistrationController::class, 'index'])->name('registration.index');
        Route::post('/registration/register', [CourseRegistrationController::class, 'register'])->name('registration.register');
        Route::put('/registration/update-section/{registrationId}', [CourseRegistrationController::class, 'updateSection'])->name('registration.update-section');
        Route::delete('/registration/drop/{registrationId}', [CourseRegistrationController::class, 'drop'])->name('registration.drop');
        Route::get('/registration/sections/{subjectId}', [CourseRegistrationController::class, 'getSections'])->name('registration.sections');
});

/*ADMIN ROUTES*/
Route::prefix('admin')->group(function () {
    //Route::middleware(['auth', 'role:admin'])->group(function () { --> bila dh ade login baru bukak 
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/manual-approval', [AdminController::class, 'manualApproval'])->name('admin.manual-approval');
        
        Route::get('/subject-assignment', [SubjectAssignmentController::class, 'index'])
        ->name('/subject-assignment');
    
        Route::post('/subject-assignment', [SubjectAssignmentController::class, 'store'])
        ->name('/subject-assignment.store');

        Route::post('/manual-approval/{id}/approve', [AdminController::class, 'approve'])->name('admin.manual-approval.approve');
        Route::delete('/manual-approval/{id}/reject', [AdminController::class, 'reject'])->name('admin.manual-approval.reject');
        
});

Route::middleware(['auth'])->group(function () {
    // Course Registration Routes
    Route::get('/course-registration', [CourseController::class, 'index'])->name('course.registration');
    Route::get('/courses/{courseCode}', [CourseController::class, 'show'])->name('course.show');
    Route::post('/courses/register', [CourseController::class, 'saveRegistration'])->name('course.register');
    Route::get('/courses/sections/{courseCode}', [CourseController::class, 'getSections']);
    Route::get('/my-registrations', [CourseController::class, 'myRegistrations'])->name('my.registrations');
    Route::delete('/drop-course/{id}', [CourseController::class, 'dropCourse'])->name('course.drop');
    Route::get('/credit-summary', [CourseController::class, 'getCreditSummary']);
    Route::get('/registered-courses', [CourseController::class, 'getRegisteredCourses']);
    Route::get('/search-courses', [CourseController::class, 'search']);
    Route::post('/manual-registration/store', [ManualRegistrationController::class, 'store'])->name('manual-registration.store');
    Route::get('admin/subject-assignment', [SubjectAssignmentController::class, 'create'])
         ->name('subject-assignment.create');
    Route::post('/admin/subject-assignment', [AdminController::class, 'store'])->name('admin.subject-assignment.store');
});
