<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeePaymentController extends Controller
{
    public function create()
    {
        $students = Student::with('user')->get();

        return view('backend.FeePayment.create',compact('students'));
    }

    public function getFees(Request $request)
    {
        $fees = Fee::with('payments')

                    ->where('student_id', $request->student_id)

                    ->where('status', '!=', 'paid')

                    ->get();

    return view('backend.FeePayment.fee_list',compact('fees'));
    }



    public function store(Request $request)
    {
    $request->validate([

        'student_id' => 'required',

        'fee_ids' => 'required|array',

        'amount' => 'required|numeric|min:1',

    ]);
    $receiptNo = 'REC-' . time();
    // Selected fees
    $fees = Fee::with('payments')

                ->whereIn('id', $request->fee_ids)

                ->orderBy('year')

                ->orderBy('month')

                ->get();

    // Remaining payment amount
    $remainingAmount = $request->amount;



    foreach($fees as $fee){

        // Already paid
        $alreadyPaid = $fee->payments->sum('amount');

        // Current due
        $due = ($fee->total_amount + $fee->late_fee)
                - $alreadyPaid;

        // Skip if already paid
        if($due <= 0){

            continue;
        }

        // If no remaining money
        if($remainingAmount <= 0){

            break;
        }

        // Full payment
        if($remainingAmount >= $due){

            $payAmount = $due;

            $fee->status = 'paid';
        }

        // Partial payment
        else{

            $payAmount = $remainingAmount;

            $fee->status = 'partial';
        }

        // Create payment record
        FeePayment::create([

            'fee_id' => $fee->id,

            'receipt_no' => $receiptNo,

            'amount' => $payAmount,

            'payment_date' => $request->payment_date,

            'payment_method' => $request->payment_method,

            'transaction_id' => $request->transaction_id,

            'note' => $request->note,

            'received_by' => Auth::id(),

        ]);

        // Save fee status
        $fee->save();

        // Reduce remaining amount
        $remainingAmount -= $payAmount;
    }
        return redirect()->route('FeePayments.receipt',$receiptNo)->with('success', 'Payment Received Successfully!');
    }


    public function index(Request $request)
    {
        $payments = FeePayment::with([
                    'fee.student.user'
                    ])
                    ->latest()
                    ->paginate(10);

            return view('backend.FeePayment.index',compact('payments'));
    }

    public function receipt($receipt_no)
    {
        $payments = FeePayment::with([
                    'fee.student.user',
                    'fee.student.class'
                ])
                ->where('receipt_no', $receipt_no)
                ->get();

        return view('backend.FeePayment.receipt',compact('payments', 'receipt_no'));
    }

    public function ledger()
    {
        $student_id = Auth::user()->student->id;

        $fees = Fee::with('payments')

                    ->where('student_id', $student_id)

                    ->latest()

                    ->get();

        $totalFees = 0;

        $totalPaid = 0;

        $totalDue = 0;

        foreach($fees as $fee){

            $paid = $fee->payments->sum('amount');

            $due = ($fee->total_amount + $fee->late_fee) - $paid;

            $totalFees += ($fee->total_amount + $fee->late_fee);

            $totalPaid += $paid;

            $totalDue += $due;
        }

        return view('backend.FeePayment.ledger', compact('fees','totalFees','totalPaid','totalDue'));
    }
}
