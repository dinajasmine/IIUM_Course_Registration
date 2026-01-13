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

    public function dashboard(){
        $registrations = \App\Models\Registration::with('subject')->get(); //TEMPORARY student id(later change to auth()->id())
        return view('student.dashboard', compact('registrations'));

    }
}