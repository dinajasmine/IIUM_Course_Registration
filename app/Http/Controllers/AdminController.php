<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Registration;

class AdminController extends Controller{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        $subjects = Subject::all(); // ambil dari database
        return view('admin.subject-assignment', compact('subjects'));
    }
     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function manualApproval(){
        $registrations = \App\Models\Registration::where('registration_type', 'MANUAL')
            ->where('status', 'PENDING')
            ->with('student') // Load student relationship
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.manual-approval', compact('registrations'));
    }

    public function approve($id){

        $registration = \App\Models\Registration::findOrFail($id);

        $registration->update([
        'status' => 'approved',
        'approved_at' => now(),
        'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Registration approved successfully!');
    }

    public function reject($id)
{
    $registration = \App\Models\Registration::findOrFail($id);
    
    $registration->update([
        'status' => 'rejected',
        'rejected_at' => now(),
        'rejected_by' => auth()->id(),
        'rejection_reason' => request('reason', 'Not specified'), // Add a field for reason
    ]);
    
    return back()->with('success', 'Registration rejected.');
}
}