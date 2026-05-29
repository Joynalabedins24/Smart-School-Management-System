<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Student;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentSessions = StudentSession::with([
                            'student.user',
                            'class',
                            'academicSession'
                            ])
                            ->where('academic_session_id',activeSession()->id)
                            ->latest()
                            ->get();

        return view('backend.StudentSessions.index',compact('studentSessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();

        $classes = Classe::all();

        $session = activeSession();

        return view('backend.StudentSessions.create',compact('students','classes','session'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required'
        ]);

        $exists = StudentSession::where('student_id',$request->student_id)
                                ->where('academic_session_id',activeSession()->id)
                                ->exists();
        if($exists){
            return redirect()->back()->with('error','Student already assigned!');
        }

        StudentSession::create([

            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'academic_session_id' => activeSession()->id,

        ]);

        return redirect()->back()->with('success','Student Session Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
