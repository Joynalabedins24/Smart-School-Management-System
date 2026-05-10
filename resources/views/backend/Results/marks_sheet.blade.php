@extends('layouts.app')

@section('content')
<form method="GET" action="{{ route('result.marksheet') }}">
@csrf
<div class="card p-3 col-10 mx-auto">
    <div class="row mb-3">



        <div class="col-md-{{ Auth::user()->student ? '5' : '3' }}">
        <!-- Class -->
            <div class="input-group">
            <label class="input-group-text" for="class_id">Class :</label>
            <select id="class_id" name="class_id" class="form-select">
                <option>Choose...</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            </div>
        </div>



        <div class="col-md-{{ Auth::user()->student ? '5' : '3' }}">
        <!-- Exam -->
            <div class="input-group">
            <label class="input-group-text" for="exam_id">Exam :</label>
            <select class="form-select" id="exam_id" name="exam_id">
                <option>Choose...</option>

            </select>
            </div>
        </div>


        <!-- Student -->
        <div class="col-md-4 {{ Auth::user()->student ? 'd-none' : '' }}">

            <select class="form-select select2" id="student_id" name="student_id" >
                <option value="">Choose Student ...</option>
            </select>

        </div>
        <!-- Subject -->
        <button class="btn btn-success col-md-2 mb-3"> Search </button>
    </div>
</div>
</form>
<div class="card p-3 col-10 mx-auto">
    <div>
        <h2 class="m-1 text-center"> School Name</h2>
        <h4 class="m-1 text-center">Mark Sheet</h4>
    </div>
    <div class="row m-3">
        <div class="col" style ="background-color:;" >
            <div><b>Student Information:</b></div>
            <div>Name:</div>
            <div>Id:</div>
            <div>Class:</div>
            <div>Section:</div>
            <div>Gender:</div>
            <div>Date of Birth:</div>
            <div></div>
            <div><b>Exam Information:</b></div>
            <div>Exam Name:</div>
            <div>Start:</div>
            <div>End:</div>
        </div>
        <div class="col" style ="background-color:green;" >
            Grading System
        </div>
    </div>
    <div class="m-3">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>GPA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $result)
                    <tr>
                        <td> {{ $key + 1 }} </td>

                        <td> {{ $result->subject->name}}</td>

                        <td> {{ $result->marks}}</td>

                        <td>
                            {{ $result->grade}}
                        </td>

                        <td>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
    </div>




</div>

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


<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-students/' + classId,
            type: 'GET',
            success: function (data) {
                $('#student_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, student) {
                    $('#student_id').append('<option value="' + student.id + '">' + student.user.name + ' ' + student.student_id + '</option>');
                });
            }
        });
    } else {
        $('#student_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>

<script>
$(document).ready(function () {
    $('.select2').select2();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>









@endsection
