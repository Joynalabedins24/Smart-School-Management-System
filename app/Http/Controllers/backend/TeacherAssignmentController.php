<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = TeacherAssignment::with([
                            'teacher.user',
                            'class',
                            'section',
                            'subject',
                            'academicSession'
                        ])->latest()->get();

        return view('backend.TeacherAssignments.index',compact('assignments'));
    }


    public function getSubjects($class_id){
        $subjects = Subject::where('class_id', $class_id)->get();
        return response()->json($subjects);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();

        $classes = Classe::all();

        $subjects = Subject::all();

        $session = activeSession();

        return view('backend.TeacherAssignments.create',compact('teachers','classes','subjects','session'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'teacher_id' => 'required',
        'class_id' => 'required',
        'section_id' => 'required',
        'subject_id' => 'required',
        ]);

        // Prevent Duplicate Assignment
        $exists = TeacherAssignment::where(
                        'teacher_id',
                        $request->teacher_id
                    )
                    ->where(
                        'class_id',
                        $request->class_id
                    )
                    ->where(
                        'section_id',
                        $request->section_id
                    )
                    ->where(
                        'subject_id',
                        $request->subject_id
                    )
                    ->where(
                        'academic_session_id',
                        activeSession()->id
                    )
                    ->exists();

        if($exists)
        {
            return redirect()->back()->with('error','Assignment Already Exists!');
        }

        TeacherAssignment::create([
        'teacher_id' => $request->teacher_id,
        'class_id' => $request->class_id,
        'section_id' => $request->section_id,
        'subject_id' => $request->subject_id,
        'academic_session_id' => activeSession()->id,
        ]);

        return redirect()->route('TeacherAssignments.index')->with('success', 'Teacher Assigned Successfully!');
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
    public function edit($id)
    {
        $assignment = TeacherAssignment::findOrFail($id);
        $teachers = Teacher::all();
        $classes = Classe::all();
        $subjects = Subject::all();
        $sections = Section::where('class_id',$assignment->class_id)
                            ->get();

        return view('backend.TeacherAssignments.edit',compact('assignment','teachers','classes','subjects','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
        ]);

        $assignment = TeacherAssignment::findOrFail($id);

        $assignment->update([
            'teacher_id' => $request->teacher_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('TeacherAssignments.index')
                ->with(
                    'success',
                    'Assignment Updated Successfully!'
                );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assignment = TeacherAssignment::findOrFail($id);

        $assignment->delete();

        return redirect()->back()->with('success','Deleted Successfully!');
    }
}
