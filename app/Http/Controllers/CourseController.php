<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseRegistration;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display available courses for registration
     */
    public function index()
    {
        // Get all courses that have sections available
        $courses = Course::with(['sections' => function($query) {
            $query->where('available_seats', '>', 0);
        }])->where('is_active', true)->get();
        
        // Calculate current credits for the student
        $currentCredits = $this->getStudentCredits(Auth::id());
        
        return view('student.course-registration', compact('courses', 'currentCredits'));
    }

    /**
     * Get sections for a specific course
     */
    public function getSections($courseCode)
    {
        $sections = CourseSection::where('course_code', $courseCode)
                                ->where('available_seats', '>', 0)
                                ->with('course')
                                ->get();
        
        return response()->json([
            'success' => true,
            'sections' => $sections
        ]);
    }

    /**
     * Register student for a course section
     */
    public function registerSection(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20',
            'section_code' => 'required|string|max:10'
        ]);
        
        $studentId = Auth::id();
        $courseCode = $request->course_code;
        $sectionCode = $request->section_code;
        
        // Check if section exists and has available seats
        $section = CourseSection::where('course_code', $courseCode)
                               ->where('section_code', $sectionCode)
                               ->first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section not found'
            ], 404);
        }
        
        if ($section->available_seats <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Section is full'
            ], 400);
        }
        
        // Check if student is already registered for this course
        $existingRegistration = CourseRegistration::where('student_id', $studentId)
                                                 ->where('course_code', $courseCode)
                                                 ->where('semester', '1 2025/2026')
                                                 ->exists();
        
        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this course'
            ], 400);
        }
        
        // Check credit limit (max 18 credits)
        $currentCredits = $this->getStudentCredits($studentId);
        $course = Course::where('code', $courseCode)->first();
        $courseCredits = $course ? $course->credits : 3;
        
        if ($currentCredits + $courseCredits > 18) {
            return response()->json([
                'success' => false,
                'message' => 'Credit limit exceeded. Maximum 18 credits allowed.'
            ], 400);
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create registration
            $registration = CourseRegistration::create([
                'student_id' => $studentId,
                'course_code' => $courseCode,
                'section_code' => $sectionCode,
                'semester' => '1 2025/2026',
                'registered_at' => now()
            ]);
            
            // Update available seats
            $section->decrement('available_seats');
            
            // Add to student's subjects
            Subject::create([
                'user_id' => $studentId,
                'course_code' => $courseCode,
                'subject_name' => $course->title ?? $courseCode,
                'semester' => '1 2025/2026',
                'section' => $sectionCode,
                'instructor' => $section->instructor,
                'schedule' => $section->schedule,
                'credits' => $courseCredits
            ]);
            
            DB::commit();
            
            // Calculate new credit total
            $newCredits = $currentCredits + $courseCredits;
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for course',
                'registration' => $registration,
                'new_credits' => $newCredits,
                'remaining_credits' => 18 - $newCredits
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student's current credit total
     */
    private function getStudentCredits($studentId)
    {
        return Subject::where('user_id', $studentId)
                     ->where('semester', '1 2025/2026')
                     ->sum('credits');
    }

    /**
     * Get student's current registrations
     */
    public function myRegistrations()
    {
        $registrations = CourseRegistration::where('student_id', Auth::id())
                                          ->where('semester', '1 2025/2026')
                                          ->with(['section', 'section.course'])
                                          ->get();
        
        $totalCredits = $this->getStudentCredits(Auth::id());
        
        return view('student.my-registrations', compact('registrations', 'totalCredits'));
    }

    /**
     * Drop a course registration
     */
    public function dropCourse($id)
    {
        $registration = CourseRegistration::where('id', $id)
                                         ->where('student_id', Auth::id())
                                         ->first();
        
        if (!$registration) {
            return back()->with('error', 'Registration not found');
        }
        
        DB::beginTransaction();
        
        try {
            // Increase available seats
            $section = CourseSection::where('course_code', $registration->course_code)
                                   ->where('section_code', $registration->section_code)
                                   ->first();
            
            if ($section) {
                $section->increment('available_seats');
            }
            
            // Remove from subjects
            Subject::where('user_id', Auth::id())
                  ->where('course_code', $registration->course_code)
                  ->where('semester', '1 2025/2026')
                  ->delete();
            
            // Delete registration
            $registration->delete();
            
            DB::commit();
            
            return back()->with('success', 'Course dropped successfully');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'Failed to drop course: ' . $e->getMessage());
        }
    }

    /**
     * View course details
     */
    public function show($courseCode)
    {
        $course = Course::with(['sections' => function($query) {
            $query->where('available_seats', '>', 0);
        }])->where('code', $courseCode)->first();
        
        if (!$course) {
            abort(404, 'Course not found');
        }
        
        // Check if student is already registered
        $isRegistered = CourseRegistration::where('student_id', Auth::id())
                                         ->where('course_code', $courseCode)
                                         ->where('semester', '1 2025/2026')
                                         ->exists();
        
        $currentCredits = $this->getStudentCredits(Auth::id());
        
        return view('student.course-details', compact('course', 'isRegistered', 'currentCredits'));
    }

    /**
     * Search courses
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $courses = Course::with(['sections' => function($q) {
            $q->where('available_seats', '>', 0);
        }])
        ->where('is_active', true)
        ->where(function($q) use ($query) {
            $q->where('code', 'LIKE', "%{$query}%")
              ->orWhere('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
        ->get();
        
        $currentCredits = $this->getStudentCredits(Auth::id());
        
        return view('student.course-registration', compact('courses', 'query', 'currentCredits'));
    }

    /**
     * Get credit summary for current student
     */
    public function getCreditSummary()
    {
        $studentId = Auth::id();
        $currentCredits = $this->getStudentCredits($studentId);
        $maxCredits = 18;
        
        return response()->json([
            'success' => true,
            'current_credits' => $currentCredits,
            'max_credits' => $maxCredits,
            'remaining_credits' => $maxCredits - $currentCredits,
            'progress_percentage' => ($currentCredits / $maxCredits) * 100
        ]);
    }

    /**
     * Get registered courses for current student
     */
    public function getRegisteredCourses()
    {
        $registrations = CourseRegistration::where('student_id', Auth::id())
                                          ->where('semester', '1 2025/2026')
                                          ->with(['section', 'section.course'])
                                          ->get()
                                          ->map(function($registration) {
                                              return [
                                                  'id' => $registration->id,
                                                  'course_code' => $registration->course_code,
                                                  'course_title' => $registration->section->course->title ?? $registration->course_code,
                                                  'section_code' => $registration->section_code,
                                                  'instructor' => $registration->section->instructor,
                                                  'schedule' => $registration->section->schedule,
                                                  'room' => $registration->section->room,
                                                  'credits' => $registration->section->course->credits ?? 0,
                                                  'registered_at' => $registration->registered_at->format('M d, Y')
                                              ];
                                          });
        
        $totalCredits = $this->getStudentCredits(Auth::id());
        
        return response()->json([
            'success' => true,
            'registrations' => $registrations,
            'total_credits' => $totalCredits
        ]);
    }

    /**
     * Save registration to database (simple version)
     */
    public function saveRegistration(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:20',
            'section_code' => 'required|string|max:10'
        ]);
        
        $studentId = Auth::id();
        $semester = '1 2025/2026';
        
        // Check if already registered
        $existing = CourseRegistration::where('student_id', $studentId)
                                     ->where('course_code', $request->course_code)
                                     ->where('semester', $semester)
                                     ->exists();
        
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Already registered for this course'
            ], 400);
        }
        
        // Get section info
        $section = CourseSection::where('course_code', $request->course_code)
                               ->where('section_code', $request->section_code)
                               ->first();
        
        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'Section not found'
            ], 404);
        }
        
        if ($section->available_seats <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Section is full'
            ], 400);
        }
        
        // Get course info
        $course = Course::where('code', $request->course_code)->first();
        
        // Save registration
        $registration = CourseRegistration::create([
            'student_id' => $studentId,
            'course_code' => $request->course_code,
            'section_code' => $request->section_code,
            'semester' => $semester,
            'registered_at' => now()
        ]);
        
        // Update available seats
        $section->decrement('available_seats');
        
        // Save to subjects table
        Subject::create([
            'user_id' => $studentId,
            'course_code' => $request->course_code,
            'subject_name' => $course ? $course->title : $request->course_code,
            'semester' => $semester,
            'section' => $request->section_code,
            'instructor' => $section->instructor,
            'schedule' => $section->schedule,
            'room' => $section->room,
            'credits' => $course ? $course->credits : 3
        ]);
        
        // Return updated credit info
        $newCredits = $this->getStudentCredits($studentId);
        
        return response()->json([
            'success' => true,
            'message' => 'Course registration saved successfully',
            'registration_id' => $registration->id,
            'new_credits' => $newCredits,
            'remaining_credits' => 18 - $newCredits
        ]);
    }
}
