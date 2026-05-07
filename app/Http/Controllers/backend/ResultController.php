<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    function create(){
        $classes = Classe::orderBY('created_at','DESC')->get();
        $section = Section::orderBY('created_at','DESC')->get();
        $student_id= Auth::user()->name;

        return view('backend.Students.create',compact('classes','section','student_id'));
    }


    public function getExams($class_id){
        $exams = Exam::where('class_id', $class_id)->get();
        return response()->json($exams);
    }


    public function index(Request $request)
    {
        $classes = Classe::all();
        $subjects = Subject::all();

        //$classes = null;
        //$subjects = null;

        $students = [];
        //new lines

        if ($request->class_id && $request->exam_id && $request->subject_id) {

        //$studentIds = Student::where('class_id', $request->class_id)
        //->where('section_id', $request->section_id)
        //->pluck('id');

        //$present = Attendances::where('date', $request->date)
        //->whereIn('student_id', $studentIds)
        //->where('status', 'present')
        //->count();
        //$totalStudent = $studentIds->count();
        //$absent = $totalStudent - $present ;
        //$percentage = round(($present / $totalStudent) * 100);
        //}

        //new lines
        //if ($request->date && $request->class_id && $request->section_id) {

        //    $classe = Classe::find($request->class_id);
        //    $exam = Exam::find($request->exam_id);

           $results = Result::with(['student.user'])
                    ->where('exam_id', $request->exam_id)
                    ->where('subject_id', $request->subject_id)
                    ->get();

            }

        //dd($students);

        return view('backend.Results.index', compact('classes', 'results','subjects'));
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
            //$lastStudent = Student::orderBy('created_at', 'desc')->first();
            $lastStudent = Student::latest()->first();
            //return  $lastStudent->student_id ;
            if ($lastStudent) {
            // 'STD-00009' → 9 + 1 = 10
            $lastIdNumber = (int) Str::after($lastStudent->student_id, 'std_');
            $newIdNumber = $lastIdNumber + 1;
            } else {
            $newIdNumber = 1;
            }
            $newStudentId = 'std_' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT); // e.g., STD-00010

            $student = new Student();
            $student->user_id = auth::user()->id;
            $student->student_id = $newStudentId;
            $student->dob = $request->dob;
            $student->gender = $request->gender;
            $student->class_id = $request->class_id;
            $student->section_id = $request->section_id;
            $student->admission_date = $request->doa;
            $student->guardian_name = $request->gName;
            $student->guardian_phone = $request->gPhone;
            $student->address = $request->address;
            $student->save();

            //database insertion
            return redirect()->route('student.index')->with('success','Information Updated Successfully!');
            }

    }


    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = Classe::all();
        $sections = Section::where('class_id',$student->class_id)->get();

        return view('backend.Students.edit', compact('student','classes','sections'));
    }



    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'dob' => $request->dob,
            'gender' => $request->gender,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'admission_date' => $request->doa,
            'guardian_name' => $request->gName,
            'guardian_phone' => $request->gPhone,
            'address' => $request->address
        ]);

        return redirect()->route('student.index')->with('success','Updated!');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success','Deleted!');
    }
}
