<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\StudentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRegistrationController extends Controller
{
    public function index()
    {
        $courses = Course::with(['sections' => function ($query) {
            $query->orderBy('section_number');
        }])->get();

        $registeredCourses = StudentRegistration::where('user_id', Auth::id())
            ->with('courseSection.course')
            ->get();

        return view('student.registration', compact('courses', 'registeredCourses'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'course_section_id' => 'required|exists:course_sections,id'
        ]);

        $section = CourseSection::findOrFail($request->course_section_id);

        // Check if section is full
        if ($section->enrolled >= $section->capacity) {
            return response()->json([
                'success' => false,
                'message' => 'The selected section is already full. Please choose a different time slot or check the timetable for available options.'
            ], 400);
        }

        // Check if already registered for this course
        $existingRegistration = StudentRegistration::where('user_id', Auth::id())
            ->whereHas('courseSection', function ($query) use ($section) {
                $query->where('course_id', $section->course_id);
            })
            ->exists();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this course.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Create registration
            StudentRegistration::create([
                'user_id' => Auth::id(),
                'course_section_id' => $request->course_section_id,
                'registered_at' => now()
            ]);

            // Increment enrolled count
            $section->increment('enrolled');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for the course.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    public function unregister(Request $request)
    {
        $request->validate([
            'course_section_id' => 'required|exists:course_sections,id'
        ]);

        DB::beginTransaction();
        try {
            $registration = StudentRegistration::where('user_id', Auth::id())
                ->where('course_section_id', $request->course_section_id)
                ->firstOrFail();

            $section = $registration->courseSection;
            
            $registration->delete();
            $section->decrement('enrolled');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully unregistered from the course.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Unregistration failed. Please try again.'
            ], 500);
        }
    }
}