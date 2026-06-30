<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with(['building', 'department'])->latest()->get();
        return view('backend.Classroom.index', compact('classrooms'));
    }

    public function create()
    {

         $buildings = \App\Models\Building::all();
         $departments = \App\Models\Department::all();
         return view('backend.Classroom.create', compact('buildings', 'departments'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'room_no'       => 'required|unique:classrooms,room_no',
            'room_name'     => 'required|string|max:255',
            'room_type'     => 'required|in:theory,lab,auditorium,conference',
            'capacity'      => 'required|integer|min:1',
            'floor_no'      => 'nullable|integer',
            'thumbnail'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // সর্বোচ্চ ২MB
            'vr_model'      => 'nullable|file|max:51200',      // সর্বোচ্চ ৫০MB
            'status'        => 'required|in:active,inactive',
        ]);
        //dd($request->all());
        $data = $request->except(['thumbnail', 'vr_model']);


        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbName = time() . '_thumb_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/classrooms/thumbnails'), $thumbName);
            $data['thumbnail'] = 'uploads/classrooms/thumbnails/' . $thumbName;
        }


        if ($request->hasFile('vr_model')) {
            $model = $request->file('vr_model');
            $modelName = time() . '_vr_' . $model->getClientOriginalName();
            $model->move(public_path('uploads/classrooms/vr_models'), $modelName);
            $data['vr_model_path'] = 'uploads/classrooms/vr_models/' . $modelName;
        }


        Classroom::create($data);

        return redirect()->route('classrooms.index')->with('success', 'Smart Classroom created successfully with VR Model!');
    }

    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);

        if (!$classroom->vr_model_path) {
            return redirect()->back()->with('error', 'This classroom does not have a VR model uploaded yet.');
        }

        return view('backend.Classroom.show', compact('classroom'));
    }
}
