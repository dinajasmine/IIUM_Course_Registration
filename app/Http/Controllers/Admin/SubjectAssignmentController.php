<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectAssignmentController extends Controller
{
    public function index()
    {
         $subjects = Subject::all();
        return view('admin.subject-assignment', compact('subjects'));
    }

    public function store(Request $request)
    {
        dd($request->subjects); // test dulu
         return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Subject assigned successfully');
    }
}
