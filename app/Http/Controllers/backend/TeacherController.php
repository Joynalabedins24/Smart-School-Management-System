<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TeacherController extends Controller
{

    function create(){
        //$classes = Classe::orderBY('created_at','DESC')->get();
        //$section = Section::orderBY('created_at','DESC')->get();
        return view('backend.Teachers.create');
    }


    function index(){
        $teachers = Teacher::with(['user'])->get();
        return view('backend.Teachers.index',compact('teachers'));
    }


    function store(Request $request){

        //validation process
        $request->validate(
            [

                'qualification'=>'required|max:30',
                'subject_specialization'=>'required|max:20',
                'hire_date'=>'required',
            ]
        );
        // Check existing of teacher & Student user_id
        $existingStudent = Student::where('user_id', auth()->user()->id)->first();
        $existingTeacher = Teacher::where('user_id', auth()->user()->id)->first();

        if ($existingStudent||$existingTeacher) {
            return redirect()->back()->with('error', 'This user is already registered as a student!');
        }
        else{
        //find last student id
        $lastTeacher = Teacher::orderBy('created_at', 'desc')->first();

        if ($lastTeacher) {
            // 'emp_00009' → 9 + 1 = 10
            $lastIdNumber = (int) Str::after($lastTeacher->employee_id, 'emp_');
            $newIdNumber = $lastIdNumber + 1;

        } else {
            $newIdNumber = 1;
        }
        $newTeacherId = 'emp_' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT); // e.g., emp_00010

        //database insertion
        $teacher = new Teacher();
        $teacher->user_id = Auth::user()->id;
        $teacher->employee_id = $newTeacherId;
        $teacher->qualification = $request->qualification;
        $teacher->subject_specialization = $request->subject_specialization;
        $teacher->hire_date = $request->hire_date;
        $teacher->save();
        return redirect()->route('teacher.index')->with('success','Information Updated Successfully!');
        }
    }

}
