<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseRegistrationController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Use Course model instead of Subject
        $courses = Course::with(['sections' => function ($query) {
            if (Schema::hasColumn('course_sections', 'is_active')) {
                $query->where('is_active', true);
            }
            $query->orderBy('section_code');
        }])
        ->where('is_active', true)
        ->get();

        // Get registered courses
        $registeredCourses = Registration::where('matric_no', Auth::user()->matric_no)
            ->where('status', 'APPROVED')
            ->with(['course', 'section'])
            ->get();

        // Get student information
        $student = Auth::user();
        
        // Add default values
        $student->matric_no = $student->matric_no ?? 'A' . str_pad($student->id, 7, '0', STR_PAD_LEFT);
        $student->program = $student->program ?? 'Computer Science';
        $student->semester = $student->semester ?? '5';
        $student->max_credit = $student->max_credit ?? 18;

        // Pass variables to match your view
        return view('student.registration', [
            'subjects' => $courses, // Pass courses as subjects to view
            'registeredSubjects' => $registeredCourses, // Pass as registeredSubjects
            'student' => $student
        ]);
    }

    public function register(Request $request)
    {
         $registration = Registration::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'section_id' => $section->id,
            'course_name' => $course->title,
            'course_code' => $course->code,
            'registration_type' => 'AUTO',
            'status' => 'APPROVED', // Auto-approve
            'semester' => 'Fall 2024',
            'requested_section' => $section->section_code,
            // No need for manual fields
        ]);

        $request->validate([
            'course_id' => 'required|exists:courses,id', // Change from subject_id
            'section_id' => 'required|exists:course_sections,id'
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $course = Course::findOrFail($request->course_id);
            $section = CourseSection::findOrFail($request->section_id);

            // Check if section is active
            if (!$section->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'This section is not available.'
                ], 400);
            }

            // Check if section is full
            if ($section->registered_count >= $section->capacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected section is already full.'
                ], 400);
            }

            // Check if already registered for this course
            $existingRegistration = Registration::where('user_id', $user->id)
                ->where('course_id', $request->course_id)
                ->where('status', 'APPROVED')
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already registered for this course.'
                ], 400);
            }

            // Calculate current credits
            $currentCredits = Registration::where('user_id', $user->id)
                ->where('status', 'APPROVED')
                ->join('courses', 'registrations.course_id', '=', 'courses.id')
                ->sum('courses.credit_hours');

            $newTotalCredits = $currentCredits + $course->credit_hours;

            // Check credit limit
            if ($newTotalCredits > ($user->max_credit ?? 18)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credit limit exceeded. Maximum allowed: ' . ($user->max_credit ?? 18) . ' credits.'
                ], 400);
            }

            // Update section count
            $section->increment('registered_count');
            
            // Check if section is now full
            if ($section->registered_count >= $section->capacity) {
                $section->update(['is_active' => false]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for ' . $course->code . ' - Section ' . $section->section_code
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    // In your controller (temporary testing)
public function registration()
{
    // Dummy data for testing
    $courses = collect([
        (object)[
            'id' => 1,
            'code' => 'MATH-101',
            'name' => 'Calculus I',
            'sections' => collect([
                (object)[
                    'id' => 1,
                    'section_number' => 'A',
                    'start_time' => '09:00',
                    'end_time' => '10:15',
                    'enrolled' => 24,
                    'capacity' => 30,
                    'is_active' => true
                ],
                (object)[
                    'id' => 2,
                    'section_number' => 'B',
                    'start_time' => '10:30',
                    'end_time' => '11:45',
                    'enrolled' => 30,
                    'capacity' => 30,
                    'is_active' => true
                ]
            ])
        ],
        (object)[
            'id' => 2,
            'code' => 'CHEM-110',
            'name' => 'General Chemistry',
            'sections' => collect([
                (object)[
                    'id' => 3,
                    'section_number' => 'A',
                    'start_time' => '11:00',
                    'end_time' => '12:15',
                    'enrolled' => 18,
                    'capacity' => 25,
                    'is_active' => true
                ]
            ])
        ]
    ]);
    
    // Empty registered courses for testing
    $registeredCourses = collect();
    
    return view('student.registration', compact('courses', 'registeredCourses'));
}
    // Add other methods...
}