<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\Attendances;
use App\Models\Classe;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $totalStudents = Student::count();

        $totalTeachers = Teacher::count();

        $totalClasses = Classe::count();

        $totalSubjects = Subject::count();

        $activeSession = AcademicSession::where('is_active', 1)->first();

    /*
    |--------------------------------------------------------------------------
    | Attendance Summary
    |--------------------------------------------------------------------------
    */

        $today = Carbon::today();

        $presentCount = Attendances::whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $absentCount = Attendances::whereDate('date', $today)
            ->where('status', 'absent')
            ->count();

        $lateCount = Attendances::whereDate('date', $today)
            ->where('status', 'late')
            ->count();

        $totalAttendance = $presentCount + $absentCount + $lateCount;

        $attendancePercentage = $totalAttendance > 0
        ? round(($presentCount / $totalAttendance) * 100)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Fee Summary
    |--------------------------------------------------------------------------
    */

        $totalCollected = FeePayment::sum('amount');
        $totalFee = Fee::sum('total_amount');
        $totalLateFee = Fee::sum('late_fee');
        $totalDue = ($totalFee + $totalLateFee) - $totalCollected;


    /*
    |--------------------------------------------------------------------------
    | Recent Payments
    |--------------------------------------------------------------------------
    */

        $recentPayments = FeePayment::latest()
            ->take(5)
            ->get();

        return view('home', compact(
                    'totalStudents',
                    'totalTeachers',
                    'totalClasses',
                    'totalSubjects',
                    'activeSession',
                    'presentCount',
                    'absentCount',
                    'lateCount',
                    'totalCollected',
                    'totalDue',
                    'recentPayments',
                    'attendancePercentage'
        ));

    }
}
