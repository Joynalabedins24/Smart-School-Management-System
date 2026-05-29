<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Fee;
use App\Models\Student;
use App\Models\StudentSession;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Late fee auto update
    $allFees = Fee::where('status', '!=', 'paid')->get();

    foreach ($allFees as $fee) {

        if (now()->gt($fee->due_date) && $fee->late_fee == 0) {

            $fee->late_fee = 100;
            $fee->save();
        }

        if (now()->lte($fee->due_date) && $fee->late_fee == 100) {

            $fee->late_fee = 0;
            $fee->save();
        }
    }

    $classes = Classe::all();

    $fees = Fee::with([
        'studentSession.student.user',
        'studentSession.class',
        'payments'
    ]);

    // Search
    if ($request->search) {

        $fees->where(function ($query) use ($request) {

            $query->whereHas('studentSession.student', function ($q) use ($request) {

                $q->where('student_id', 'like', '%' . $request->search . '%');

            })

            ->orWhereHas('studentSession.student.user', function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%');

            });
        });
    }

    // Class Filter
    if ($request->class_id) {

        $fees->whereHas('studentSession', function ($q) use ($request) {

            $q->where('class_id', $request->class_id)
              ->where('academic_session_id', activeSession()->id);

        });
    }

    // Fee Type Filter
    if ($request->fee_type) {

        $fees->where('fee_type', $request->fee_type);
    }

    // Status Filter
    if ($request->status) {

        $fees->where('status', $request->status);
    }

    // Month Filter
    if ($request->month) {

        $fees->where('month', $request->month);
    }

    $fees = $fees->latest()->paginate(10);

    return view('backend.Fees.index', compact('fees', 'classes'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::orderBY('created_at','DESC')->get();

        return view('backend.Fees.create',compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
        $request->validate([
            'class_id'   => 'required',
            'fee_type'   => 'required',
            'year'       => 'required',
            'amount'     => 'required',
            'due_date'   => 'required',
        ]);

        // active student sessions
        $studentSessions= StudentSession::where('class_id', $request->class_id)
                        ->where('academic_session_id', activeSession()->id)
                        ->get();

        foreach ($studentSessions as $studentSession) {
            //prevent duplicate data
            $exists = Fee::where('student_session_id', $studentSession->id)
                        ->where('fee_type', $request->fee_type)
                        ->where('month', $request->month)
                        ->where('year', $request->year)
                        ->exists();

            if (!$exists) {

                Fee::create([
                'student_session_id' => $studentSession->id,
                'fee_type'           => $request->fee_type,
                'month'              => $request->month,
                'year'               => $request->year,
                'total_amount'       => $request->amount,
                'due_date'           => $request->due_date,
                ]);
            }
        }

        return redirect()->route('Fees.index')->with('success', 'Fee Generated Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fee = Fee::with([
                'studentSession.student.user',
                'studentSession.class',
                'studentSession.section',
                'payments'
        ])
        ->findOrFail($id);

        return view('backend.Fees.details', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fee = Fee::findOrFail($id);
        return view('backend.Fees.edit', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([

            'fee_type' => 'required',

            'total_amount' => 'required|numeric|min:0',

                'due_date' => 'required|date',

        ]);

        $fee = Fee::findOrFail($id);

        $fee->update([

        'fee_type' => $request->fee_type,

        'month' => $request->month,

        'year' => $request->year,

        'total_amount' => $request->total_amount,

        'due_date' => $request->due_date,

        ]);

        return redirect()->route('Fees.index')->with('success', 'Fee Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        $fees = Fee::where('fee_type', $request->fee_type)
            ->where('month', $request->month)
            ->whereHas('student', function($q) use ($request){
                $q->where('class_id', $request->class_id);
            })
            ->get();
        // Prevent delete if payment exists
        foreach($fees as $fee){

            if($fee->payments->count() > 0){

                return back()->with(
                'error',
                'Some fees already paid.'
                );
            }
        }

        foreach($fees as $fee){

            $fee->delete();
        }

        return back()->with('success','Fees Deleted Successfully!');
    }
}
