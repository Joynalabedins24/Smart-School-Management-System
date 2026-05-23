@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>Edit Teacher Assignment</h4>

        </div>

        <div class="card-body">

            <form action="{{ route(
                    'TeacherAssignments.update',
                    $assignment->id
                ) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Teacher -->
                    <div class="col-md-6 mb-3">

                        <label>Teacher</label>

                        <select name="teacher_id"
                                class="form-select"
                                required>

                            @foreach($teachers as $teacher)

                                <option value="{{ $teacher->id }}"
                                {{ $assignment->teacher_id == $teacher->id ? 'selected' : '' }}>

                                    {{ $teacher->user->name ?? '' }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Class -->
                    <div class="col-md-6 mb-3">

                        <label>Class</label>

                        <select name="class_id"
                                id="class_id"
                                class="form-select"
                                required>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}"
                                {{ $assignment->class_id == $class->id ? 'selected' : '' }}>

                                    {{ $class->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Section -->
                    <div class="col-md-6 mb-3">

                        <label>Section</label>

                        <select name="section_id"
                                id="section_id"
                                class="form-select"
                                required>

                            @foreach($sections as $section)

                                <option value="{{ $section->id }}"
                                {{ $assignment->section_id == $section->id ? 'selected' : '' }}>

                                    {{ $section->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Subject -->
                    <div class="col-md-6 mb-3">

                        <label>Subject</label>

                        <select name="subject_id"
                                class="form-select"
                                required>

                            @foreach($subjects as $subject)

                                <option value="{{ $subject->id }}"
                                {{ $assignment->subject_id == $subject->id ? 'selected' : '' }}>

                                    {{ $subject->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Update Assignment

                </button>

            </form>

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

<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-subjects/' + classId,
            type: 'GET',
            success: function (data) {
                $('#subject_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, subject) {
                    $('#subject_id').append('<option value="' + subject.id + '">' + subject.name + '</option>');
                });
            }
        });
    } else {
        $('#subject_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>
@endsection
