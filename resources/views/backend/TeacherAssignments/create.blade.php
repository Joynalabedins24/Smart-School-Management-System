@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>Teacher Assignment</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('TeacherAssignments.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <!-- Teacher -->
                    <div class="col-md-6 mb-3">

                        <label>Teacher</label>

                        <select name="teacher_id"
                                class="form-select"
                                required>

                            <option value="">

                                Select Teacher

                            </option>

                            @foreach($teachers as $teacher)

                                <option value="{{ $teacher->id }}">

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

                            <option value="">

                                Select Class

                            </option>

                            @foreach($classes as $class)

                                <option value="{{ $class->id }}">

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

                            <option value="">

                                Select Section

                            </option>

                        </select>

                    </div>

                    <!-- Subject -->
                    <div class="col-md-6 mb-3">

                        <label>Subject</label>

                        <select name="subject_id"
                                id="subject_id"
                                class="form-select"
                                required>
                                    <option value="">
                                        Select Subject
                                    </option>
                        </select>

                    </div>

                    <!-- Session -->
                    <div class="col-md-6 mb-3">

                        <label>Academic Session</label>

                        <input type="text"
                               class="form-control"
                               value="{{ $session->name }}"
                               readonly>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Save Assignment

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
