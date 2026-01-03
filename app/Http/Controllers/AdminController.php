<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Registration;

class AdminController extends Controller{
    public function manualApproval(){

        $registrations = []; //$registrations = Registration::with('subject', 'user')
            //->where('status', 'pending')
            //->get();

            return view('admin.manual-approval', compact('registrations'));
    }

    public function approve($id){

        $reg = Registration::find($id);
        $reg->status = 'approved';
        $reg->save();

        return back();
    }
}