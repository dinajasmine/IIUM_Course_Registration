<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class ManualRegistrationController extends Controller
{
    public function create()
    {
        return view('student.manual-registration');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255',
            'current_credit_hours' => 'required|numeric|min:0|max:999.99',
            'completed_credit_hours' => 'required|numeric|min:0|max:999.99',
            'cgpa' => 'required|numeric|min:0|max:4.00',
            'requested_section' => 'required|string|max:10',
            'semester' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        $registration = \App\Models\Registration::create([
            'user_id' => auth()->id(),
            'subject_name' => $request->subject_name,
            'course_code' => $request->course_code,
            'current_credit_hours' => $request->current_credit_hours,
            'completed_credit_hours' => $request->completed_credit_hours,
            'cgpa' => $request->cgpa,
            'requested_section' => $request->requested_section,
            'semester' => $request->semester,
            'reason' => $request->reason,
            'registration_type' => 'MANUAL',
            'status' => 'PENDING',
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Manual registration request submitted successfully! It will be reviewed by admin.');
    }
}