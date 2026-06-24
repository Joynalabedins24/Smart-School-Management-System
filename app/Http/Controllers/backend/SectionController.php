<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    //create
    function create(){
        //$classes = Classe::orderBY('created_at','DESC')->get();
        $classes = Classe::orderBY('created_at','DESC')->get();
        return view('backend.Section.create',compact('classes'));
    }
    //index
    function index(){
        $Classes = Classe::orderBY('numeric_value')->get();
        $sections = Section::with(['class'])->get();

        return view('backend.Section.index',compact('sections','Classes'));
    }

    //store
    function store(Request $request){

        //validation process
        $request->validate(
            [
                'sectionName'=>'required|max:20',
                'Capacity'=>'required|integer',
                'ClasseName'=>'required'
            ]
        );

        //database insertion
        $section = new Section();
        $section->class_id  = $request->ClasseName;
        $section->name =$request->sectionName;
        $section->capacity = $request->Capacity;
        $section->save();
        return redirect()->route('sections.index')->with('success','Information Updated Successfully!');
    }


    public function edit($id)
    {
        $section = Section::findOrFail($id);
        $classes = Classe::all(); // dropdown এর জন্য

        return view('backend.Section.edit', compact('section','classes'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required',
            'class_id' => 'required'
        ]);

        $section = Section::findOrFail($id);

        $section->update([
            'name' => $request->name,
            'capacity'=> $request->capacity,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('section.index')->with('success', 'Section Updated Successfully');
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->back()->with('success', 'Section Deleted Successfully');
    }


}
//<?php
//                                $designationval = $teacher->designation;
//
//s
//                                foreach ($designations as $key => $designation) {
//                                    if ($designationval == $designation->id){
//                                        echo $designation->Designation;
//                                    }
//                                }
//
//
