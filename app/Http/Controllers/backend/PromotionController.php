<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Classe;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::all();

        $sessions = AcademicSession::all();

        $students = collect();
        if($request->from_session_id && $request->from_class_id){
            $students = StudentSession::with(['student.user','fees.payments'])
                    ->where('academic_session_id',$request->from_session_id)
                    ->where('class_id',$request->from_class_id)
                    ->where('status','active')
                    ->get();

            foreach($students as $student){
                $student->total_due = 0;

                foreach($student->fees as $fee){
                    $paid = $fee->payments->sum('amount');

                    $student->total_due += ($fee->total_amount +
                                            $fee->late_fee -
                                            $paid
                                            );
                }
            }
        }

        return view('backend.Promotions.index', compact('classes','sessions','students'));
    }
}
