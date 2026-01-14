<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Registration;

class StudentController extends Controller{
    public function manual(){

        $subjects = [];//$subjects = Subject::all();
        return view('student.manual-registration', compact('subjects'));
    }

    public function storeManual(Request $request){

        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50',
            'credit_hours' => 'required|numeric|min:0',
            'semester' => 'required|string|max:20',
            'reason' => 'required|string|max:1000',
        ]);

        return redirect()->route('student.manual-registration')->with('success', 'Registration submitted successfully!');
    }

    public function dashboard()
    {
        // Get subjects for the current logged-in student
        $subjects = Subject::where('user_id', auth()->id())
                          ->where('semester', '1 2025/2026')
                          ->get();
        
        return view('student.dashboard', compact('subjects'));
    }

    public function timetable(){
    // Dummy timetable data
    $timetable = [
        [
            'code' => 'BICS1301',
            'subject' => 'Introduction to Human Computer Interaction',
            'day' => 'Monday',
            'time' => '9:00 AM - 11:00 AM',
            'venue' => 'KICT Lab 1'
        ],
        [
            'code' => 'BICS1302',
            'subject' => 'Introduction to Database Management',
            'day' => 'Tuesday',
            'time' => '10:00 AM - 12:00 PM',
            'venue' => 'KICT Lecture Hall'
        ],
        [
            'code' => 'BICS1303',
            'subject' => 'Web Technologies and Development',
            'day' => 'Thursday',
            'time' => '2:00 PM - 4:00 PM',
            'venue' => 'KICT Lab 3'
        ],
    ];

    return view('student.timetable', compact('timetable'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function registrationStatus(){
        $registrations = \App\Models\Registration::where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')    
            ->get();
        return view('student.registration-status', compact('registrations'));

    }
}