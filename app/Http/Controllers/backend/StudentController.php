<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentSession;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function index(Request $request)
    {
        $query  = StudentSession::with(['student.user','class','section'])
                ->where('academic_session_id',activeSession()->id);

        // search
        if ($request->search)
        {
            $query ->whereHas('student',function ($q) use ($request) {
                $q->where(  'student_id',
                            'like',
                            '%'.$request->search.'%'
                        )
                    ->orWhereHas('user',function ($q2) use ($request) {
                    $q2->where( 'name',
                                'like',
                                '%'.$request->search.'%'
                            );
                    });
            });
        }

        // class filter
        if ($request->class_id)
        {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->paginate(10);

        $classes = Classe::all();

        return view('backend.Students.index', compact('students','classes'));
    }


    function store(Request $request){
        //validation process
        $request->validate(
            [

                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'dob' => 'required|date',
                'doa' => 'required|date',
                'gender' => 'required',
                'class_id' => 'required',
                'section_id' => 'required',
                'gName' => 'required',
                'gPhone' => 'required',
                'address' => 'required',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]
        );
        DB::beginTransaction();

        try {

            // User Create
            $user = User::create([
            'name'     => $request->name,

            'email'    => $request->email,

            'password' => Hash::make($request->password),

            ]);

            if ($request->hasFile('profile_photo')) {

                $photoName = time().'_'.
                $request->file('profile_photo')
                        ->getClientOriginalName();

                $request->file('profile_photo')
                        ->move(public_path('uploads/students'),$photoName);
            }

            // Assign Student Role
            $user->assignRole('Student');

            // Student ID Generate
            $student_id = Student::max('id') + 1;

            $student_code = 'STD-' . date('Y') . '-' . str_pad($student_id, 4,'0', STR_PAD_LEFT );

            // Student Create
            $student = Student::create([

            'user_id'      => $user->id,

            'student_id'   => $student_code,

            'dob'          => $request->dob,

            'admission_date'=> $request->doa,

            'gender'       => $request->gender,

            'guardian_name' => $request->gName,

            'guardian_phone'=> $request->gPhone,

            'address'       => $request->address,

            'profile_photo' => $photoName ?? null,

            ]);

            StudentSession::create([

            'student_id' => $student->id,

            'class_id' => $request->class_id,

            'section_id'   => $request->section_id,

            'academic_session_id' => activeSession()->id,

            'roll_no' => null,

            'status' => 'active',

            ]);


            DB::commit();

            return redirect()->route('student.index')->with(
                                    'success',
                                    'Student Admission Completed Successfully!'
            );
        }catch (\Exception $e) {

            DB::rollBack();

            return back()->withInput()->with(
                            'error',
                            $e->getMessage()
            );
        }

    }



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
