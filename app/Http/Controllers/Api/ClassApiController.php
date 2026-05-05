<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;

class ClassApiController extends Controller
{
    // 📄 Get All Classes
    public function index()
    {
        $classes = Classe::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $classes
        ]);
    }

    // ➕ Create Class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'numeric_value' => 'required|numeric',
            'class_teacher_id' => 'nullable|exists:teachers,id'
        ]);

        $class = Classe::create([
            'name' => $request->name,
            'numeric_value' => $request->numeric_value,
            'class_teacher_id' => $request->class_teacher_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Class Created Successfully',
            'data' => $class
        ]);
    }

    // 🔍 Single Class
    public function show($id)
    {
        $class = Classe::with('classTeacher')->find($id);

        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $class
        ]);
    }

    // ✏️ Update Class
    public function update(Request $request, $id)
    {
        $class = Classe::find($id);

        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found'
            ], 404);
        }

        $class->update([
            'name' => $request->name,
            'numeric_value' => $request->numeric_value,
            'class_teacher_id' => $request->class_teacher_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Class Updated',
            'data' => $class
        ]);
    }

    // ❌ Delete
    public function destroy($id)
    {
        $class = Classe::find($id);

        if (!$class) {
            return response()->json([
                'status' => false,
                'message' => 'Class not found'
            ], 404);
        }

        $class->delete();

        return response()->json([
            'status' => true,
            'message' => 'Class Deleted'
        ]);
    }
}
