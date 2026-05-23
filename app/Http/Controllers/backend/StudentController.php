<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentSession;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function create(){
        $classes = Classe::orderBY('created_at','DESC')->get();
        $section = Section::orderBY('created_at','DESC')->get();
        $student_id= Auth::user()->name;

        return view('backend.Students.create',compact('classes','section','student_id'));
    }


    public function getSections($class_id){
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json($sections);
    }

    function index(Request $request){

        $query  = Student::with(['user', 'currentSession']);

        // Search
        if ($request->search) {
        $query->where('student_id','like','%'.$request->search.'%')
              ->orWhereHas('user', function($q) use ($request){
                  $q->where('name','like','%'.$request->search.'%');
              });
        }

        if ($request->class_id) {
            $query->whereHas('currentSession', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        $students = $query->paginate(10);

        $classes = Classe::all();
        return view('backend.Students.index',compact('students','classes'));
    }




    function store(Request $request){

        //validation process
        $request->validate(
            [

                'dob'=>'required|date|before:2015-01-01',
                'doa' => 'required|date|before_or_equal:today|after:dob',
                'gender'=>'required',
                'class_id'=>'required|max:20',
                'section_id'=>'required|max:20',
                'gName'=>'required|max:20',
                'gPhone'=>'required',
                'address'=>'required'
            ]
        );
        $existingStudent = Student::where('user_id', Auth::user()->id)->first();
        $existingTeacher = Teacher::where('user_id', Auth::user()->id)->first();

        if ($existingStudent||$existingTeacher) {
            return redirect()->back()->with('error', 'This user is already registered as a student!');
        }
        else{
            //Generate Student ID
            //find last student id
            $lastStudent = Student::latest()->first();
            //return  $lastStudent->student_id ;
            if ($lastStudent) {
            // 'STD-00009' → 9 + 1 = 10
            $lastIdNumber = (int) Str::after($lastStudent->student_id, 'std_');
            $newIdNumber = $lastIdNumber + 1;
            } else {
            $newIdNumber = 1;
            }
            $newStudentId = 'std_' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);

            $student = Student::create([
            'user_id'          => Auth::user()->id,
            'student_id'       => $newStudentId,
            'dob'              => $request->dob,
            'gender'           => $request->gender,
            'admission_date'   => $request->doa,
            'guardian_name'    => $request->gName,
            'guardian_phone'   => $request->gPhone,
            'address'          => $request->address
            ]);

            StudentSession::create([
            'student_id'            => $student->id,
            'class_id'              => $request->class_id,
            'section_id'            => $request->section_id,
            'academic_session_id'   => activeSession()->id,
            ]);

            //database insertion
            return redirect()->route('student.index')->with('success','Information Updated Successfully!');
        }

    }


    //public function edit($id)
    //{
    //    $student = Student::findOrFail($id);
    //    $classes = Classe::all();
    //    $sections = Section::where('class_id',$student->class_id)->get();

    //    return view('backend.Students.edit', compact('student','classes','sections'));
    //}

    public function edit($id)
    {
        $student = Student::with([
                    'currentSession.class',
                    'currentSession.section'
                ])->findOrFail($id);

        $classes = Classe::all();

        $sections = Section::all();

        $session = $student->currentSession;

        return view('backend.Students.edit',compact('student','classes','sections','session'));
    }


    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'dob' => $request->dob,
            'gender' => $request->gender,
            //'class_id' => $request->class_id,
            //'section_id' => $request->section_id,
            'admission_date' => $request->doa,
            'guardian_name' => $request->gName,
            'guardian_phone' => $request->gPhone,
            'address' => $request->address
        ]);

        // Current Session Update
        $studentSession = $student->currentSession;

        if($studentSession)
        {
            $studentSession->update([

                'class_id' => $request->class_id,

                'section_id' => $request->section_id,

            ]);
        }

        return redirect()->route('student.index')->with('success','Updated!');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success','Deleted!');
    }


}
