<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Classe;
use App\Models\Exam;
use App\Models\Promotion;
use App\Models\Result;
use App\Models\StudentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
    $classes = Classe::all();

    $sessions = AcademicSession::all();

    $students = collect();

    if ($request->from_session_id && $request->from_class_id) {

        $students = StudentSession::with(['student.user','fees.payments'])
                    ->where('academic_session_id', $request->from_session_id)
                    ->where('class_id', $request->from_class_id)
                    ->where('status', 'active')
                    ->get();
        $finalExam = Exam::where('academic_session_id',$request->from_session_id)
                        ->where('class_id',$request->from_class_id)
                        ->where('exam_type','final')
                        ->first();
        foreach ($students as $student) {

            // Due Calculation
            $student->total_due = 0;

            foreach ($student->fees as $fee) {
                $paid = $fee->payments->sum('amount');
                $student->total_due += ($fee->total_amount +($fee->late_fee ?? 0) - $paid);
            }
            // Default Values
            $student->result_status = 'Pass';
            $student->promotion_action = 'promote';

            // Final Exam Result Check
            if ($finalExam) {

                $results = Result::where('student_session_id',$student->id)
                            ->where('exam_id',$finalExam->id)
                            ->get();
                $hasFail = $results->contains(function ($result) {
                    return $result->grade == 'F';
                });
                if ($hasFail) {
                    $student->result_status = 'Fail';
                }
            }
            // Promotion Decision
            if ($student->total_due > 0) {

                $student->promotion_action = 'hold';

            }
            elseif ($student->result_status == 'Fail') {

                $student->promotion_action = 'repeat';

            }
            else {

                $student->promotion_action = 'promote';
            }
        }
    }

    return view('backend.Promotions.index',compact('classes','sessions','students'));
    }



    public function process(Request $request)
    {
        //DB::beginTransaction();
        //try {
            foreach ($request->students as $studentId => $action) {

                $currentSession = StudentSession::where('student_id',$studentId)
                            ->where('academic_session_id',$request->from_session_id)
                            ->first();

                if (!$currentSession) {
                    continue;
                }

                // Hold Student
                if ($action == 'hold') {
                    Promotion::create([
                        'student_id'      => $studentId,
                        'from_session_id' => $request->from_session_id,
                        'to_session_id'   => $request->to_session_id,
                        'from_class_id'   => $request->from_class_id,
                        'to_class_id'     => $request->to_class_id,
                        'action'          => 'hold',
                    ]);

                    continue;
                }

                // Duplicate Protection
                $alreadyExists = StudentSession::where('student_id', $studentId)
                            ->where('academic_session_id',$request->to_session_id)
                            ->exists();

                if ($alreadyExists) {
                    continue;
                }

                // Repeat হলে same class
                $nextClassId = $action == 'repeat' ? $request->from_class_id : $request->to_class_id;

                // New Session Create
                StudentSession::create([
                    'student_id'          => $studentId,
                    'class_id'            => $nextClassId,
                    'academic_session_id' => $request->to_session_id,
                    'roll_no'             => null,
                    'status'              => 'active',
                ]);

                // Old Session Close
                $currentSession->update(['status' => 'graduated']);

                // Promotion History
                Promotion::create([
                    'student_id'      => $studentId,
                    'from_session_id' => $request->from_session_id,
                    'to_session_id'   => $request->to_session_id,
                    'from_class_id'   => $request->from_class_id,
                    'to_class_id'     => $nextClassId,
                    'action'          => $action,
                ]);
            }

            //DB::commit();

            return redirect()   ->route('promotions.index')
                                ->with( 'success',
                                        'Promotion Process Completed Successfully'
                                        );
        //} catch (\Exception $e) {

            //DB::rollBack();

            //return back()->with('error',$e->getMessage());
        //}
    }
}
