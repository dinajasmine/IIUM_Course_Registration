<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Registration;

class AdminController extends Controller{

    public function manualApproval(){
    $registrations = Registration::where('status', 'pending')
        ->with('student')
        ->get();
    
    return view('admin.manual-approval', compact('registrations'));
    }

    public function approve($id){

        Registration::where('id', $id)->update(['status' => 'approved']);

        return redirect()->back();
    }
}