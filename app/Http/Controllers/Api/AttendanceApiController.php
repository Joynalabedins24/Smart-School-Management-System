<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->students as $studentId => $data) {

            Attendances::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date
                ],
                [
                    'status' => $data['status'] ?? 'absent',
                    'remarks' => $data['remarks'] ?? null
                ]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Attendance Saved'
        ]);
    }


    public function byDate($date)
    {
        $data = Attendances::with('student.user')
            ->where('date', $date)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }



    public function byClassSection($class_id, $section_id)
    {
        $students = Student::with(['user', 'attendances'])
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $students
        ]);
    }



    public function studentHistory($student_id)
    {
        $data = Attendances::where('student_id', $student_id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
