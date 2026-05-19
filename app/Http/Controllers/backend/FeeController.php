<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $allFees = Fee::where('status', '!=', 'paid')->get();

        foreach($allFees as $fee){

            if(now()->gt($fee->due_date) && $fee->late_fee == 0){

                $fee->late_fee = 100;

                $fee->save();
            }

            if(now()->lte($fee->due_date) && $fee->late_fee == 100){

                $fee->late_fee = 0;

                $fee->save();
            }
        }

        $classes = Classe::all();

        $fees = Fee::with([ 'student.user',
                            'student.class',
                            'payments'
                        ]);


        if ($request->search) {

            $fees->where(function($query) use ($request){

                $query->where('student_id', 'like', '%'.$request->search.'%')

                        ->orWhereHas('student.user', function($q) use ($request){

                        $q->where('name', 'like', '%'.$request->search.'%');

                        });
                });
        }


        // Class Filter
        if($request->class_id){

            $fees->whereHas('student', function($q) use ($request){

            $q->where('class_id', $request->class_id);

            });
        }
        // Fee Type Filter
        if($request->fee_type){

            $fees->where('fee_type', $request->fee_type);
        }


        if($request->status){

            $fees->where('status', $request->status);

        }

        if($request->month){

            $fees->where('month', $request->month);

        }
        $fees = $fees->paginate(10);
        return view('backend.Fees.index',compact('fees','classes'));
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

        $students = Student::where('class_id', $request->class_id)->get();
        //print($students);
        //print($request->total_amount);

        foreach($students as $student){
            $exists = Fee::where('student_id', $student->id)
            ->where('fee_type', $request->fee_type)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->exists();

            if(!$exists){
                Fee::create([
                'student_id' => $student->id,
                'fee_type' => $request->fee_type,
                'month' => $request->month,
                'year' => $request->year,
                'total_amount' => $request->amount,
                'due_date' => $request->due_date,
                ]);
            }
        }
        return redirect()->route('Fees.index')->with('success','Information Updated Successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fee = Fee::with([
        'student.user',
        'student.class',
        'payments'
        ])->findOrFail($id);

        return view('backend.Fees.show', compact('fee'));
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
}
