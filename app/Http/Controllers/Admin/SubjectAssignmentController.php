<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SubjectAssignmentController extends Controller
{
     public function index()
    {
        $subjects = Subject::where('is_active', true)->get();
        $students = User::where('role', 'student')->get();
        
        return view('admin.subject_assignment', compact('subjects', 'students'));
    }

    public function store(Request $request)
    {
        dd($request->subjects); // test dulu
         return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Subject assigned successfully');
    }
}
