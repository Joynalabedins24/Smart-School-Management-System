@extends('layouts.app')

@section('content')

<div class="card p-3 col-10 mx-auto">

    <!-- FILTER FORM -->
    <form method="GET" action="{{ route('attendance.report') }}" class="row mb-3">

        <div class="col-md-3">
            <input type="date" name="date" class="form-control" required>
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
            <button class="btn btn-primary w-100">Search</button>
        </div>

    </form>


    <div class="row">

        <div class="col text-start m-2">
            Date: {{ \Carbon\Carbon::parse($date)->format('jS F Y') }}
        </div>

        <div class="col text-center m-2">
            Class : {{ $classe->name ?? '' }}
        </div>

        <div class="col text-end m-2">
            Section : {{ $section->name ?? '' }}
        </div>
    </div>
    <div class="row text-primary">

        <div class="col text-start m-2">
            <strong>Total Student : {{ $totalStudent }}</strong>

        </div>

        <div class="col text-center m-2">
            <strong>Present : {{ $present ?? '' }}</strong>

        </div>

        <div class="col text-end m-2">
            <strong>Absent : {{ $absent ?? '' }}</strong>

        </div>
        <div class="col text-end m-2">
            <strong>Attendance : {{ $percentage ?? '' }}%</strong>

        </div>

    </div>

    <div class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 2px">
        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
    </div>

    <!-- RESULT TABLE -->
    @if(count($students) > 0)

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>

        <tbody>
        @foreach($students as $key => $student)

            @php
                $attendance = $student->attendances->first();
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->student_id }}</td>

                <td>
                    @if($attendance && $attendance->status == 'present')
                        <span class="badge bg-success">Present</span>
                    @else
                        <span class="badge bg-danger">Absent</span>
                    @endif
                </td>

                <td>
                    {{ $attendance->remarks ?? '-' }}
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
