<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Section;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
{
    // Get the first student for testing
    $student = Student::first();
    
    // Try different approaches:
    
    // Approach 1: If registrations uses student_id foreign key
    $registrations = Registration::where('matric_no', $student->matric_no)
                            ->where('status', 'registered')
                            ->get();
    
    // Approach 2: If registrations uses matric_no
    // $registrations = Registration::where('matric_no', $student->matric_no)
    //                             ->where('status', 'registered')
    //                             ->get();
    
    // Approach 3: Just get all registrations for debugging
    $registrations = Registration::all();
    
    return view('registration.index', compact('student', 'registrations'));
}
    
    public function register(Request $request)
    {
        // Simple version for testing
        $student = Student::first();
        
        $registration = Registration::create([
            'student_id' => $student->id,
            'subject_id' => $request->subject_id,
            'section_id' => $request->section_id,
            'status' => 'registered',
        ]);
        
        return response()->json(['success' => true, 'message' => 'Registered successfully']);
    }
    
    public function getSections($subjectId)
    {
        $sections = Section::where('subject_id', $subjectId)->get();
        return response()->json($sections);
    }
    
    public function updateSection(Request $request, $registrationId)
    {
        $registration = Registration::find($registrationId);
        $registration->update(['section_id' => $request->new_section_id]);
        
        return response()->json(['success' => true, 'message' => 'Section updated']);
    }
    
    public function drop($registrationId)
    {
        $registration = Registration::find($registrationId);
        $registration->update(['status' => 'dropped']);
        
        return response()->json(['success' => true, 'message' => 'Subject dropped']);
    }
}