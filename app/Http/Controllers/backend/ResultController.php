<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use App\Models\StudentSession;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    function create(){
        $classes = Classe::orderBY('created_at','DESC')->get();
        //$section = Section::orderBY('created_at','DESC')->get();
        //$student_id= Auth::user()->name;

        return view('backend.Results.create',compact('classes'));
    }


   public function getExams($class_id)
    {
        $exams = Exam::where('class_id', $class_id)
                    ->where('academic_session_id',activeSession()->id)
                    ->get();
        return response()->json($exams);
}



    public function getSubjects($classId , $examId){
        $subjects = Result::join('exams', 'results.exam_id', '=', 'exams.id')
                ->join('subjects', 'results.subject_id', '=', 'subjects.id')
                ->where('exams.class_id', $classId)
                ->where('results.exam_id', $examId)
                ->distinct()
                ->get(['subjects.id', 'subjects.name']);
        return response()->json($subjects);
    }

    public function getSubjectsByClass($classId){
        $subjects   = Subject::where('class_id', $classId)
                            ->get();
        return response()->json($subjects);
    }


    public function getStudentsForResult($class_id, $exam_id, $subject_id)
    {
        $students = StudentSession::with(['student.user'])
                                ->where('academic_session_id',activeSession()->id)
                                ->where('class_id',$class_id)
                                ->get();
        foreach ($students as $student)
        {
            $result = Result::where('student_session_id',$student->id)
                            ->where('exam_id',$exam_id)
                            ->where('subject_id',$subject_id)
                            ->first();

            $student->marks = $result->marks ?? '';
            $student->grade = $result->grade ?? '';
        }

        return response()->json($students);
    }




    public function index(Request $request)
    {
        $classes = Classe::all();

        $classe = null;
        $subject = null;
        $exam = null;

        $results = [];

        if ($request->class_id && $request->exam_id && $request->subject_id)
        {
        $classe = Classe::find( $request->class_id);
        $exam = Exam::where('academic_session_id', activeSession()->id)
                ->findOrFail( $request->exam_id);
        $subject = Subject::find($request->subject_id);

        $results = Result::with(['studentSession.student.user'])
                ->where('exam_id', $request->exam_id)
                ->where('subject_id',$request->subject_id)
                ->whereHas('studentSession',function ($q) use ($request) {
                          $q->where('academic_session_id',activeSession()->id)
                            ->where('class_id',$request->class_id);
                        })->get();
        }
        return view('backend.Results.index',compact('classes','results','subject','exam','classe'));
    }


    public function marksheet(Request $request)
    {
        $classes = Classe::all();
        $results = [];
        $cgpa = 0;
        $exam = null;
        if (Auth::user()->student){

            $student_id = Auth::user()->student->id;
            $student = Student::find($student_id);
            if($request->exam_id){
                $exam_id = $request->exam_id;
                $exam = Exam::find($exam_id);
                $results = Result::with(['student.user', 'exam'])
                        ->where('exam_id', $exam_id)
                        ->where('student_id', $student_id)
                        ->get();

                $totalPoints = 0;

                foreach ($results as $result) {

                    if ($result->grade == 'A+') {
                    $point = 5.00;
                    } elseif ($result->grade == 'A') {
                    $point = 4.00;
                    } elseif ($result->grade == 'A-') {
                    $point = 3.50;
                    } elseif ($result->grade == 'B') {
                    $point = 3.00;
                    } elseif ($result->grade == 'C') {
                    $point = 2.00;
                    } else {
                    $point = 0.00;
                    }

                    $totalPoints += $point;
                }

                $cgpa = $totalPoints / $results->count();

            }
        }
        else {
            $student = [];
            //$exam = [];
            if($request->exam_id && $request->student_id){
                $student_id = $request->student_id;
                $exam_id = $request->exam_id;
                $student = Student::find($student_id);
                $exam = Exam::find($exam_id);
                $results = Result::with(['student.user', 'exam'])
                        ->where('exam_id', $exam_id)
                        ->where('student_id', $student_id)
                        ->get();

                $totalPoints = 0;

                foreach ($results as $result) {

                    if ($result->grade == 'A+') {
                    $point = 5.00;
                    } elseif ($result->grade == 'A') {
                    $point = 4.00;
                    } elseif ($result->grade == 'A-') {
                    $point = 3.50;
                    } elseif ($result->grade == 'B') {
                    $point = 3.00;
                    } elseif ($result->grade == 'C') {
                    $point = 2.00;
                    } else {
                    $point = 0.00;
                    }

                    $totalPoints += $point;
                }

                $cgpa = $totalPoints / $results->count();
            }
        }

        return view('backend.Results.marks_sheet', compact('classes','student','exam','results','cgpa'));
    }





    public function store(Request $request)
{
    $request->validate([
        'exam_id' => 'required',
        'subject_id' => 'required',
        'students' => 'required|array'
    ]);
    foreach ($request->students as $studentSessionId => $data)
    {
        Result::updateOrCreate(
            [
                'student_session_id' => $studentSessionId,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id
            ],
            [
                'marks' => $data['marks'] ?? '',
                'grade' => $data['grade'] ?? ''
            ]
        );
    }
    return back()->with('success','Marks Saved Successfully!');
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
