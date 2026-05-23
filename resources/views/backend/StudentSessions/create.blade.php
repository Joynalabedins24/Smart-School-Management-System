@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>Student Session Entry</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('StudentSessions.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <!-- Student -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Student

                        </label>

                        <select name="student_id"
                                class="form-select"
                                required>

                            <option value="">

                                Select Student

                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}">

                                    {{ $student->user->name ?? '' }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Class -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Class

                        </label>

                        <select name="class_id"
                                class="form-select"
                                id="class_id"
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
                    <div class="col-md-4 mb-3">

                        <label for="validationCustom05"  class="form-label">
                            Section
                        </label>

                        <select class="form-select" name="section_id"  id="section_id" required>
                            <option value="{{ old('section_id') }}">Choose...</option>
                        </select>

                    </div>

                    <!-- Session -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Academic Session

                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $session->name }}"
                               readonly>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Save Student Session

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

@endsection
