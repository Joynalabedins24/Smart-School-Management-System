<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Classe;
use App\Models\Section;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function create()
    {
        $classes = Classe::all();
        return view('backend.Attendance.create', compact('classes'));
    }




    public function getStudents($class_id, $section_id = null)
    {
        $students = Student::with('user')
                ->where('class_id', $class_id)
                ->when($section_id, function ($query) use ($section_id) {
                    $query->where('section_id', $section_id);
                })
                ->get();

        return response()->json($students);
    }


    public function getStudentsForEdit($class_id, $section_id, $date)
    {
        $students = Student::with('user')
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->get();

        foreach ($students as $student) {
            $attendance = Attendances::where('student_id', $student->id)
                ->where('date', $date)
                ->first();

            $student->status = $attendance->status ?? null;
            $student->remarks = $attendance->remarks ?? null;
        }

        return response()->json($students);
    }



    public function store(Request $request)
    {
        foreach ($request->students as $studentId => $data) {
            $request->validate(
                [
                    'date' => 'required|date',
                    'students' => 'required|array'
                ]
            );

            Attendances::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date
                ],
                [
                    'status' => isset($data['status']) ? 'present' : 'absent',
                    'remarks' => $data['remarks'] ?? null
                ]
            );
        }

        return back()->with('success', 'Attendance Saved');
    }


    public function report(Request $request)
    {
        $classes = Classe::all();

        $classe = null;
        $section = null;
        $date = $request->date;

        $students = [];
        //new lines
        $present = 0;
        $absent = 0;
        $totalStudent = 0;
        $percentage = 0;

        if ($request->date && $request->class_id && $request->section_id) {

        $studentIds = Student::where('class_id', $request->class_id)
        ->where('section_id', $request->section_id)
        ->pluck('id');

        $present = Attendances::where('date', $request->date)
        ->whereIn('student_id', $studentIds)
        ->where('status', 'present')
        ->count();
        $totalStudent = $studentIds->count();
        $absent = $totalStudent - $present ;
        $percentage = round(($present / $totalStudent) * 100);
        }

        //new lines
        if ($request->date && $request->class_id && $request->section_id) {

            $classe = Classe::find($request->class_id);
            $section = Section::find($request->section_id);

            $students = Student::with(['user', 'attendances' => function ($q) use ($request) {
                $q->where('date', $request->date);
            }])
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();
        }

        return view('backend.Attendance.report', compact('classes', 'students','classe','section',
        'date','present','absent','totalStudent','percentage'));
    }



    //Attendance report Pdf download
    public function reportPdf(Request $request)
    {
        $classe = null;
        $section = null;
        $date = $request->date;

        $students = [];
        //new lines
        $present = 0;
        $absent = 0;
        $totalStudent = 0;
        $percentage = 0;

        if ($request->date && $request->class_id && $request->section_id) {

        $studentIds = Student::where('class_id', $request->class_id)
        ->where('section_id', $request->section_id)
        ->pluck('id');

        $present = Attendances::where('date', $request->date)
        ->whereIn('student_id', $studentIds)
        ->where('status', 'present')
        ->count();
        $totalStudent = $studentIds->count();
        $absent = $totalStudent - $present ;
        $percentage = round(($present / $totalStudent) * 100);
        }

        //new lines
        if ($request->date && $request->class_id && $request->section_id) {

            $classe = Classe::find($request->class_id);
            $section = Section::find($request->section_id);

            $students = Student::with(['user', 'attendances' => function ($q) use ($request) {
                $q->where('date', $request->date);
            }])
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->get();
        }
        //return view('backend.Attendance.Pdfmake.reportPdf', compact( 'students','classe','section',
        //'date','present','absent','totalStudent','percentage'));
        $pdf = Pdf::loadview('backend.Attendance.Pdfmake.reportPdf', compact( 'students','classe','section',
        'date','present','absent','totalStudent','percentage'));


        return $pdf->download('attendance-report.pdf');
    }




    public function edit()
    {
        $classes = Classe::all();
        return view('backend.Attendance.edit', compact('classes'));
    }


    public function monthlyReport(Request $request)
    {
        $classes = Classe::all();
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $month = $request->month; // format: 2026-05
        $classe = null;
        $section = null;
        $students = [];
        $formattedMonth = null;

        if ($class_id && $section_id && $month) {
            $classe = Classe::find($request->class_id);
            $section = Section::find($request->section_id);
            $monthNumber = date('m', strtotime($month));

            $formattedMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');

            $monthName = date('F', mktime(0, 0, 0, $monthNumber, 1));
            $year = date('Y', strtotime($month));

            $students = Student::with('user')
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();

            foreach ($students as $student) {

                $present = Attendances::where('student_id', $student->id)
                    ->whereMonth('date', $monthNumber)
                    ->whereYear('date', $year)
                    ->where('status', 'present')
                    ->count();

                $total = Attendances::where('student_id', $student->id)
                    ->whereMonth('date', $monthNumber)
                    ->whereYear('date', $year)
                    ->count();

                $student->present = $present;
                $student->absent = $total - $present;
                $student->percentage = $total > 0 ? round(($present / $total) * 100) : 0;
            }
        }

        return view('backend.Attendance.monthly_report', compact('students','classes','classe','section','formattedMonth'));
    }



    public function studentCalendar(Request $request, $student_id = null)
    {
    // যদি user student হয়
    if (Auth::user()->student) {
        $student = Auth::user()->student;
    } else {
        // admin/teacher হলে id লাগবে
        $student = Student::with('user')->findOrFail($student_id);
    }

    $month = $request->month ?? date('Y-m');

    $start = Carbon::parse($month)->startOfMonth();
    $end = Carbon::parse($month)->endOfMonth();

    $attendances = Attendances::where('student_id', $student->id)
        ->whereBetween('date', [$start, $end])
        ->get()
        ->keyBy(function ($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        });

    return view('backend.Attendance.calender', compact('student','attendances','month'));
    }
}
