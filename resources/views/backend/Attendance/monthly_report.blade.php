@extends('layouts.app')


@section('content')
<div class="card p-3 col-10 mx-auto">
    <!-- FILTER FORM -->
    <form method="GET" action="{{ route('attendance.monthlyReport') }}" class="row mb-3">

        <div class="col-md-3">
        <input type="month" name="month" class="form-control" required>
        </div>

        <div class="col-md-3">
            <select name="class_id" id="class_id" class="form-control" required>
                <option>Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select id="section_id" name="section_id" class="form-control mb-3">
            <option>Select Section</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary w-100">Generate Report</button>
        </div>

    </form>
</div>
<div id="printArea" class="card p-3 col-10 mx-auto">
    <div class="text-center mb-4">

        <h1>Your School Name</h1>

        <p>School Address Here</p>

        <h5 class="mt-2">
            ATTENDANCE REPORT
        </h5>
        <p>Session : {{ $currentSession->name ?? '' }}</p>

    </div>

    <div class="row text-primary">

        <div class="col text-start m-2">
            <strong> Month: {{ $formattedMonth ?? '' }}</strong>

        </div>

        <div class="col text-center m-2">
            <strong>Class : {{ $classe->name ?? '' }}</strong>

        </div>

        <div class="col text-end m-2">
            <strong>Section : {{ $section->name ?? '' }}</strong>

        </div>
    </div>


    <!-- RESULT TABLE -->
    @if(count($students) > 0)

    <table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Percentage</th>
        </tr>
    </thead>
    <tbody>

    @foreach($students as $key => $student)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $student->student->user->name }}</td>
            <td>{{ $student->present }}</td>
            <td>{{ $student->absent }}</td>

            <td style="width:200px;">
                <div class="progress">
                    <div class="progress-bar
                        {{ $student->percentage >= 80 ? 'bg-success' : ($student->percentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                        style="width: {{ $student->percentage }}%">
                        {{ $student->percentage }}%
                    </div>
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
    </table>

    @else
        <p class="text-center text-muted">No data found</p>
    @endif

</div>

    <div class="col-11 d-flex flex-row-reverse mt-2">
        <div class="col-md-2">

            <button onclick="window.print()" class="btn btn-primary w-100">
                🖨️ Print Report
            </button>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-sections/' + classId,
            type: 'GET',
            success: function (data) {
                $('#section_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, section) {
                    $('#section_id').append('<option value="' + section.id + '">' + section.name + '</option>');
                });
            }
        });
    } else {
        $('#section_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>

@endsection
