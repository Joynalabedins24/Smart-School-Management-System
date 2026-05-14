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
            <select id="class_id"
                    name="class_id"
                    class="form-select"
                    {{ Auth::user()->student ? 'disabled' : '' }}>
                        <option>Choose...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ Auth::user()->student && Auth::user()->student->class_id == $class->id ? 'selected' : '' }}
                                >{{ $class->name }}
                            </option>
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
        <h5 class="m-1 text-center">Final Exam</h5>
    </div>
    <div class="row m-3">
        <div class="col float-start" style ="background-color:; font-size: 16px;" >
            <div><b>Student Information:</b></div>
            <div class="row">
                <div class="col-4">Name</div>
                <div class="col-6">: {{$student->user->name ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Id</div>
                <div class="col-6">: {{$student->student_id ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Class</div>
                <div class="col-6">: {{$student->class->name ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Section</div>
                <div class="col-6">: {{$student->section->name ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Gender</div>
                <div class="col-6">: {{$student->gender ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Date of Birth</div>
                <div class="col-6">: {{ optional($student)->dob ? \Carbon\Carbon::parse($student->dob)->format('jS F Y') : '' }}
                </div>
            </div>

            <div><b>Exam Information:</b></div>
            <div class="row">
                <div class="col-4">Exam Name</div>
                <div class="col-6">: {{$exam->name ?? ""}}</div>
            </div>
            <div class="row">
                <div class="col-4">Start</div>
                <div class="col-6">: {{--{{ \Carbon\Carbon::parse($exam->start_date)->format('jS F Y') ""}} --}}
                    {{ optional($exam)->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('jS F Y') : '' }}
                </div>
            </div>
            <div class="row">
                <div class="col-4">End</div>
                <div class="col-6">:
                    {{ optional($exam)->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('jS F Y') : '' }}
                </div>
            </div>
        </div>
        <div class="col " style ="background-color:;" >
            <div class="col-6 float-end">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Marks (%)</th>
                            <th>Grade</th>
                            <th>GPA</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>80 - 100</td>
                            <td>A+</td>
                            <td>5.00</td>
                        </tr>

                        <tr>
                            <td>70 - 79</td>
                            <td>A</td>
                            <td>4.00</td>
                        </tr>

                        <tr>
                            <td>60 - 69</td>
                            <td>A-</td>
                            <td>3.50</td>
                        </tr>

                        <tr>
                            <td>50 - 59</td>
                            <td>B</td>
                            <td>3.00</td>
                        </tr>

                        <tr>
                            <td>40 - 49</td>
                            <td>C</td>
                            <td>2.00</td>
                        </tr>

                        <tr>
                            <td>33 - 39</td>
                            <td>D</td>
                            <td>1.00</td>
                        </tr>

                        <tr>
                            <td>0 - 32</td>
                            <td>F</td>
                            <td>0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="m-3">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th class="col-7">Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>GPA</th>
                        <th>CGPA</th>
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

                        <td >
                            @if($result->grade == 'A+')
                                5.00
                            @elseif($result->grade == 'A')
                                4.00
                            @elseif($result->grade == 'A-')
                                3.50
                            @elseif($result->grade == 'B')
                                3.00
                            @elseif($result->grade == 'C')
                                2.00
                            @elseif($result->grade == 'D')
                                1.00
                            @else
                                0.00
                            @endif
                        </td>
                        @if($key == 0)
                        <th rowspan="{{ $results->count() }}" class="align-middle" >
                            {{ number_format($cgpa, 2) }}
                        </th>
                        @endif
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

<script>
    $(document).ready(function () {

    $('#class_id').change(function () {

        let class_id = $(this).val();

        // ajax call for exam load

    });

        @if(Auth::user()->student)
            $('#class_id').trigger('change');
        @endif

    });
</script>









@endsection
