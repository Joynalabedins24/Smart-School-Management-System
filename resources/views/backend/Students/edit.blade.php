@extends('layouts.app')

@section('content')

<div class="shadow-sm card col-11 mx-auto p-4">

    <h4 class="mb-3">Edit Student</h4>

    {{-- Success / Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('student.update', $student->id) }}" method="POST" class="row g-3">
        @csrf
        {{-- @method('PUT') --}}

        <!-- User Name (Display only) -->
        <div class="col-md-6">
            <label class="form-label">User Name</label>
            <input type="text" class="form-control"
                   value="{{ $student->user->name }}"
                   disabled readonly>
        </div>

        <!-- Student ID -->
        <div class="col-md-6">
            <label class="form-label">Student ID</label>
            <input type="text" class="form-control"
                   value="{{ $student->student_id }}"
                   disabled readonly>
        </div>

        <!-- DOB -->
        <div class="col-md-4">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob"
                   value="{{ old('dob', $student->dob ? $student->dob->format('Y-m-d') : '') }}"
                   class="form-control">
        </div>

        <!-- Admission Date -->
        <div class="col-md-4">
            <label class="form-label">Admission Date</label>
            <input type="date" name="doa"
                   value="{{ old('doa', $student->admission_date ? $student->admission_date->format('Y-m-d') : '') }}"
                   class="form-control">
        </div>

        <!-- Gender -->
        <div class="col-md-4">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $student->gender == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <!-- Class -->
        <div class="col-md-6">
            <label class="form-label">Class</label>
            <select name="class_id" id="class_id" class="form-select">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        {{ $student->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Section -->
        <div class="col-md-6">
            <label class="form-label">Section</label>
            <select name="section_id" id="section_id" class="form-select">
                @foreach($sections as $section)
                    <option value="{{ $section->id }}"
                        {{ $student->section_id == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Guardian Name -->
        <div class="col-md-6">
            <label class="form-label">Guardian Name</label>
            <input type="text" name="gName"
                   value="{{ old('gName', $student->guardian_name) }}"
                   class="form-control">
        </div>

        <!-- Guardian Phone -->
        <div class="col-md-6">
            <label class="form-label">Guardian Phone</label>
            <input type="text" name="gPhone"
                   value="{{ old('gPhone', $student->guardian_phone) }}"
                   class="form-control">
        </div>

        <!-- Address -->
        <div class="col-md-12">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $student->address) }}</textarea>
        </div>

        <!-- Submit -->
        <div class="col-12">
            <button class="btn btn-success">Update Student</button>
            <a href="{{ route('student.index') }}" class="btn btn-secondary">Back</a>
        </div>

    </form>
</div>


{{-- AJAX Section Load --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();

    if (classId) {
        $.ajax({
            url: '/get-sections/' + classId,
            type: 'GET',
            success: function (data) {
                $('#section_id').empty();

                $.each(data, function (key, section) {
                    $('#section_id').append('<option value="'+section.id+'">'+section.name+'</option>');
                });
            }
        });
    }
});
</script>

@endsection
