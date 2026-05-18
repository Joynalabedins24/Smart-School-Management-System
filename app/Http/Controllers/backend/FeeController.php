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
    public function index()
    {
        //print("datadase a dukce");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
