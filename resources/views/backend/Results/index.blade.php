@extends('layouts.app')

@section('content')


<div class="card p-3 col-10 mx-auto">
    <form method="GET" action="{{ route('results.index') }}" class="row mb-3">



        <div class="col-md-3">
            <select name="class_id" id="class_id" class="form-control" required>
                <option>Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select id="exam_id" name="exam_id" class="form-control mb-3">
            <option>Select Exam</option>
            </select>
        </div>

        <div class="col-md-3">
            <select id="subject_id" name="subject_id" class="form-control mb-3">
            <option>Select Subject</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary w-100">Search</button>
        </div>

    </form>
</div>

<div class="card p-3 col-10 mx-auto">
    <div class ="row text-center mb-2">
        <h3>Subject wise Exam Result</h3>
    </div>

    <div class="row text-primary">

        <div class="col text-start m-2">
            <strong>Date : {{  now()->format('jS F Y') }}</strong>

        </div>


        <div class="col text-end m-2">
            <strong>Class taken By : {{ $subject->teacher->user->name ?? '' }}</strong>

        </div>

    </div>


   <div class="row">

        <div class="col text-start m-2">
            Class: {{ $classe->name ?? '-'}}
        </div>

        <div class="col text-center m-2">
            Exam : {{ $exam->name ?? '' }}
        </div>

        <div class="col text-end m-2">
            Subject : {{ $subject->name ?? '' }}
        </div>
    </div>
    {{--

    <div class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 2px">
        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
    </div> --}}

    <!-- RESULT TABLE -->
    @if(count($results) > 0)

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>
        </thead>

        <tbody>
        @foreach($results as $key => $result)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $result->studentSession->student->user->name }}</td>
                <td>{{ $result->studentSession->student->student_id }}</td>

                <td>
                    @if($result)
                        {{$result->marks}}
                    @else
                        N/A
                    @endif
                </td>

                <td>
                    {{ $result->grade ?? '-' }}
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    @else
        <p class="text-center text-muted">No data found</p>
    @endif
    <div class="d-flex flex-row-reverse">
        <div class="col-md-2">
            <a href="{{ route('attendance.pdf', [
                    'class_id' => request('class_id'),
                    'section_id' => request('section_id'),
                    'date' => request('date')
                    ]) }}"
                class="btn btn-danger w-100">
                Download PDF
            </a>
        </div>
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
function loadSubjects() {
    var classId = $('#class_id').val();
    var examId = $('#exam_id').val();

    if (classId && examId) {
        $.ajax({
            url: '/get-subjects/' + classId + '/' + examId,
            type: 'GET',
            success: function (data) {
                $('#subject_id').empty().append('<option value="">Choose...</option>');

                $.each(data, function (key, subject) {
                    $('#subject_id').append(
                        '<option value="' + subject.id + '">' + subject.name + '</option>'
                    );
                });
            }
        });
    } else {
        $('#subject_id').empty().append('<option value="">Choose...</option>');
    }
}

// class change
$('#class_id').on('change', function () {
    loadSubjects();
});

// exam change
$('#exam_id').on('change', function () {
    loadSubjects();
});
</script>

@endsection
