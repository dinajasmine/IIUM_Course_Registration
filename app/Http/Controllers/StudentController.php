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

        Registration::create([
            'user_id' => 1, //TEMPORARY student id(later change to auth()->id())
            'subject_id' => $request->subject_id,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Registration submitted successfully!');
    }

    public function dashboard(){
        $registrations = \App\Models\Registration::with('subject')->where('user_id', 1)->get(); //TEMPORARY student id(later change to auth()->id())
        return view('student.dashboard', compact('registrations'));

    }
}