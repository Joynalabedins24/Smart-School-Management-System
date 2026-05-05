@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-5 mx-auto p-3">

    <form action="{{ route('classe.update', $class->id) }}" method="POST" class="row g-3 needs-validation">
        @csrf

        <!-- Class Name -->
        <div class="col-md">
            <label class="form-label">Class Name</label>
            <input type="text" name="className" class="form-control"
                   value="{{ $class->name }}" required>
        </div>

        <!-- Numeric Value -->
        <div class="col-md">
            <label class="form-label">Numerical Value</label>
            <input type="text" name="nValue" class="form-control"
                   value="{{ $class->numeric_value }}" required>
        </div>

        <!-- Teacher -->
        <div class="col-md">
            <label class="form-label">Teacher</label>
            <select class="form-select select2" name="Teacher_id" required>
                <option value="">Choose...</option>

                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ $class->class_teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->user->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Update Class</button>
        </div>

    </form>

</div>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    $('.select2').select2();
});
</script>

@endsection
