<?php

namespace App\Http\Controllers\backend;

use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClasseController extends Controller
{
    function create(){
        //$classes = Classe::orderBY('created_at','DESC')->get();
        $teachers = Teacher::orderBY('created_at','DESC')->get();
        return view('backend.Classes.create',compact('teachers'));
    }
    function index(){
        $Classes = Classe::with(['classTeacher.User'])->get();
        return view('backend.Classes.index',compact('Classes'));
    }

    function store(Request $request){

        //validation process
        $request->validate(
            [
                'className'=>'required|max:20',
                'nValue'=>'required',
                'Teacher_id'=>'required'
            ]
        );

        //database insertion
        $classe = new classe();
        $classe->name =$request->className;
        $classe->numeric_value = $request->nValue;
        $classe->class_teacher_id  = $request->Teacher_id;
        $classe->save();
        return redirect()->route('classe.index')->with('success','Information Updated Successfully!');
    }

    public function edit($id)
    {
        $teachers = Teacher::orderBY('created_at','DESC')->get();
        $class = Classe::findOrFail($id);
        return view('backend.classes.edit', compact('class','teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'className' => 'required',
            'nValue' => 'required',
            'Teacher_id' => 'nullable'
        ]);

        $class = Classe::findOrFail($id);

        $class->update([
            'name' => $request->className,
            'numeric_value' => $request->nValue,
            'class_teacher_id' => $request->Teacher_id,
        ]);

        return redirect()->route('classe.index')->with('success', 'Class Updated Successfully');
    }
    public function destroy($id)
    {
        $class = Classe::findOrFail($id);
        $class->delete();

        return redirect()->back()->with('success', 'Class Deleted');
    }
}
