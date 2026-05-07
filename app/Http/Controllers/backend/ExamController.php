<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        $exams = Exam::with('classe')->paginate(10);
        return view('backend.Exam.index', compact('exams','classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('backend.Exam.create', compact('classes'));
    }

    public function store(Request $request)
    {
        //validation process
        $request->validate(
            [
                'examName'=>'required',
                'startDate' => 'required|date',
                'endDate'=>'required|date',
                'ClasseName'=>'required'
            ]
        );


        $exam = new Exam();
        $exam->name =$request->examName;
        $exam->start_date = $request->startDate;
        $exam->end_date  = $request->endDate;
        $exam->class_id  = $request->ClasseName;
        $exam->save();
        return redirect()->route('exams.index')->with('success', 'Exam created');
    }


    public function edit($id)
    {
        //$exam = Exam::findOrFail($id);
        $exam = Exam::with('classe')->findOrFail($id);
        $classes = Classe::all();
        return view('backend.Exam.edit', compact('exam','classes'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $exam = Exam::findOrFail($id);

        $exam->update([
            'name' => $request->examName,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('exams.index')->with('success','Updated!');
    }


}
