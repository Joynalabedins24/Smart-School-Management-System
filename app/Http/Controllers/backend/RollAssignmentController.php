<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class RollAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::all();

        $students = collect();

        if($request->class_id){

            $students = StudentSession::with('student.user')
                ->where('academic_session_id', activeSession()->id)
                ->where('class_id', $request->class_id)
                ->orderBy('roll_no')
                ->get();
        }

        return view('backend.RollAssignment.index', compact('classes','students'));
    }


    public function store(Request $request)
    {
        foreach($request->students as $sessionId => $rollNo){

            StudentSession::where('id', $sessionId)
                            ->update(['roll_no' => $rollNo]);
        }
        return back()->with('success','Roll Assigned Successfully');
    }
}
