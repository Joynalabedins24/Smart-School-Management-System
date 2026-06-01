<?php

namespace App\Http\Controllers\backend;

use App\Models\Classe;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    function create(){
        $classes = Classe::orderBY('created_at','DESC')->get();
        $teachers = Teacher::orderBY('created_at','DESC')->get();
        return view('backend.Subjects.create',compact('classes','teachers'));
    }

     function index(){
        $Subjects = Subject::with(['class','teacher.user'])->get();
        return view('backend.Subjects.index',compact('Subjects'));
    }


    function store(Request $request){

        //validation process
        $request->validate(
            [
                'subjectName'=>'required|max:20',
                'class_id'=>'required',
            ]
        );

        //database insertion
        $subject = new Subject();
        $subject->name =$request->subjectName;
        $subject->class_id = $request->class_id;
        $subject->save();
        return redirect()->route('subject.index')->with('success','Information Updated Successfully!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $classes = Classe::all(); // dropdown এর জন্য

        return view('backend.Subjects.edit', compact('subject','classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subjectName' => 'required',
            'class_id' => 'required',
        ]);

        $subject = Subject::findOrFail($id);

        $subject->update([
            'name' => $request->subjectName,
            'class_id' => $request->class_id
        ]);

        return redirect()->route('subject.index')->with('success', 'Class Updated Successfully');
    }
}
