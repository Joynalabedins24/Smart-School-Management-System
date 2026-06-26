<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    //store method start
    function store(Request $request){

        //validation process
        $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'qualification' => 'required|max:255',
                'subject_specialization' => 'required|max:255',
                'phone' => 'required',
                'address' => 'required|max:600',
                'hire_date' => 'required|date',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


            DB::beginTransaction();
            try {
                // Upload Photo
                $photoName = null;

                if ($request->hasFile('profile_photo')) {

                    $photoName = time().'_'. $request->file('profile_photo')->getClientOriginalName();
                    $request->file('profile_photo')->move(public_path('uploads/teachers'), $photoName);

                }
                // Create User
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $user->assignRole('teacher');
                $lastTeacher = Teacher::latest()->first();
                $nextId = $lastTeacher ? ((int) Str::after( $lastTeacher->employee_id, 'EMP-')) + 1 : 1;
                $employeeId = 'EMP-'.str_pad( $nextId, 5, '0', STR_PAD_LEFT);

                Teacher::create([
                    'user_id' => $user->id,
                    'employee_id' => $employeeId,
                    'qualification' => $request->qualification,
                    'subject_specialization' => $request->subject_specialization,
                    'hire_date' => $request->hire_date,
                    'profile_photo' => $photoName,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]);

                DB::commit();

                return redirect()->route('teacher.index')->with('success','Teacher Created Successfully');

            } catch (\Exception $e) {

                DB::rollBack();

                return back()->withInput()->with('error',$e->getMessage());
            }
    }
    //store method end

    //edit method start
    public function edit($id)
    {
        $teacher = Teacher::with([
                    'user'
                ])->findOrFail($id);

        //$classes = Classe::all();

        //$sections = Section::all();

        //$session = $student->currentSession;

        return view('backend.Teachers.edit',compact('teacher'));
    }
    //edit method end
    //update method start

    public function update(Request $request,$id)
    {

        $teacher = Teacher::with('user')
                        ->findOrFail($id);

        $request->validate([

            'name'=>'required|max:255',

            'email'=>'required|email|unique:users,email,'.$teacher->user->id,

            'qualification'=>'required',

            'subject_specialization'=>'required',

            'phone'=>'required',

            'address'=>'required',

            'hire_date'=>'required|date',

            'profile_photo'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        DB::beginTransaction();

        try{

            $teacher->user->update([

                'name'=>$request->name,

                'email'=>$request->email,

            ]);

            if($request->hasFile('profile_photo')){

                if($teacher->profile_photo && file_exists(
                                                            public_path('uploads/teachers/'. $teacher->profile_photo)
                                                        ))
                {
                    unlink(public_path('uploads/teachers/'.$teacher->profile_photo));
                }

                $photoName=time().'_'.$request->file('profile_photo')->getClientOriginalName();
                $request->file('profile_photo')->move(public_path('uploads/teachers'),$photoName);
                $teacher->profile_photo=$photoName;
            }
            $teacher->qualification=$request->qualification;
            $teacher->subject_specialization=
            $request->subject_specialization;
            $teacher->phone=$request->phone;
            $teacher->address=$request->address;
            $teacher->hire_date=$request->hire_date;
            $teacher->save();

            DB::commit();
            return redirect()->route('teacher.index')->with('success','Teacher Updated Successfully.');
        }
        catch(\Exception $e){

            DB::rollBack();
            return back()->withInput()->with('error',$e->getMessage());
        }
    }

    //update method end


    //Delete method start
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $teacher = Teacher::with('user')->findOrFail($id);

            // Delete Profile Photo
            if ($teacher->profile_photo && file_exists(public_path('uploads/teachers/' . $teacher->profile_photo)))
            {
                unlink(public_path('uploads/teachers/' . $teacher->profile_photo));
            }

            // Delete User (Teacher will be deleted automatically via cascade)
            $teacher->user->delete();

            DB::commit();

            return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //Delete method end

}
