@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('Fees.update', $fee->id) }}">
@csrf
@method('PUT')
<div class="card p-3 col-10 mx-auto">
    <div>
        <h3 class="text-center">Edit Fee</h3>
    </div>
    <div class="row mb-3">

        <div class="col-md-12">
        <!-- Student -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="class_id">Student Name :</label>
            <input type="text" name="student" class="form-control" value="{{ $fee->studentSession->student->user->name }}" readonly>
            </div>
        </div>

        <div class="col-md-6">
        <!-- Student_Id -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="class_id">Student ID :</label>
            <input type="text" name="student_id" class="form-control" value="{{ $fee->studentSession->student->student_id }}" readonly>
            </div>
        </div>


        <div class="col-md-6">
        <!-- class -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="class_id">Class :</label>
            <input type="text" name="class" class="form-control" value="{{ $fee->studentSession->class->name }}" readonly>
            </div>
        </div>



        <div class="col-md-6">
        <!-- Fee Type -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="fee_type">Types of Fee :</label>
            <select class="form-select" id="fee_type" name="fee_type">
                <option>Choose...</option>
                <option value="monthly fee" {{ $fee->fee_type == 'monthly fee' ? 'selected' : '' }}>Monthly Fee</option>
                <option value="exam fee" {{ $fee->fee_type == 'exam fee' ? 'selected' : '' }}>Exam Fee</option>
                <option value="lab fee" {{ $fee->fee_type == 'lab fee' ? 'selected' : '' }}>Lab Fee</option>
            </select>
            </div>
        </div>


        <div class="col-md-6">
            <!-- Amount -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="Amount">Amount</label>
            <input type="number" name="total_amount" class="form-control" value="{{ $fee->total_amount }}" >
            </div>
        </div>



        <div class="col-md-4">
            <!-- Month -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="month">Month</label>
            <input type="month" name="month" class="form-control" value="{{ $fee->month }}" >
            </div>
        </div>

        <div class="col-md-4">
            <!-- Year -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="year">Year</label>
            <input type="year" name="year" class="form-control" value="{{ $fee->year }}">
            </div>
        </div>

        <div class="col-md-4">
            <!-- Due Date -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="month">Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ $fee->due_date }}">
            </div>
        </div>






    </div>
    <button class="btn btn-success col-2 mt-3">Update Fee</button>
</div>


</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
