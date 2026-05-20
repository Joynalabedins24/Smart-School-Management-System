@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('Fees.store') }}">
@csrf
<div class="card p-3 col-10 mx-auto">
    <div>
        <h3 class="text-center">Class Wise Fee Create</h3>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
        <!-- Class -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="class_id">Class :</label>
            <select id="class_id" name="class_id" class="form-select">
                <option>Choose...</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            </div>
        </div>



        <div class="col-md-6">
        <!-- Fee Type -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="fee_type">Types of Fee :</label>
            <select class="form-select" id="fee_type" name="fee_type">
                <option>Choose...</option>
                <option value="monthly fee">Monthly Fee</option>
                <option value="exam fee">Exam Fee</option>
                <option value="lab fee">Lab Fee</option>
            </select>
            </div>
        </div>



        <div class="col-md-3">
            <!-- Month -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="month">Month</label>
            <input type="month" name="month" class="form-control" >
            </div>
        </div>

        <div class="col-md-3">
            <!-- Year -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="year">Year</label>
            <input type="year" name="year" class="form-control" >
            </div>
        </div>

        <div class="col-md-3">
            <!-- Due Date -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="month">Due Date</label>
            <input type="date" name="due_date" class="form-control" >
            </div>
        </div>

        <div class="col-md-3">
            <!-- Amount -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="Amount">Amount</label>
            <input type="number" name="amount" class="form-control" >
            </div>
        </div>




    </div>
    <button class="btn btn-success col-2 mt-3">Save Fee</button>
</div>


</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-exams/' + classId,
            type: 'GET',
            success: function (data) {
                $('#exam_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, exam) {
                    $('#exam_id').append('<option value="' + exam.id + '">' + exam.name + '</option>');
                });
            }
        });
    } else {
        $('#exam_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>










@endsection
