@extends('layouts.app')

@section('content')

<div class="card p-3 col-10 mx-auto">

    <form method="GET" action="{{ route('roll.assignment') }}">

        <div class="row">

            <div class="col-md-10">

                <div class="input-group">

                    <label class="input-group-text">
                        Class
                    </label>

                    <select name="class_id" id ="class_id" class="form-select" required>
                            <option value="">
                                Choose...
                            </option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('class_id') == $class->id ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    Load Students

                </button>

            </div>

        </div>

    </form>

</div>


@if($students->count() > 0)

<form method="POST"
      action="{{ route('roll.assignment.store') }}">

    @csrf

    <div class="card p-3 col-10 mx-auto mt-3">

        <div class="d-flex justify-content-between mb-3">

            <h4>

                Roll Assignment

            </h4>

            <button type="submit"
                    class="btn btn-success">

                Save Rolls

            </button>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th width="5%">
                        #
                    </th>

                    <th>
                        Student Name
                    </th>

                    <th>
                        Student ID
                    </th>

                    <th width="20%">
                        Roll No
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($students as $student)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $student->student->user->name }}
                    </td>

                    <td>
                        {{ $student->student->student_id }}
                    </td>

                    <td>

                        <input type="number"
                               name="students[{{ $student->id }}]"
                               class="form-control"
                               value="{{ $student->roll_no }}"
                               min="1">

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</form>

@endif
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
