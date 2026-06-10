@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <h3>Edit Permission</h3>

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">

        @csrf
        @method('PUT')

        <!-- Permission Name -->
        <div class="mb-3">
            <label>Permission Name</label>
            <input type="text"
                   name="name"
                   value="{{ $permission->name }}"
                   class="form-control"
                   required>
        </div>

        <!-- Module -->
        <div class="mb-3">
            <label>Module</label>
            <select name="module" class="form-control" required>
                <option >
                    Choose Module
                </option>
                <option value="student" {{ $permission->module == 'student' ? 'selected' : '' }}>
                    Student
                </option>

                <option value="teacher" {{ $permission->module == 'teacher' ? 'selected' : '' }}>
                    Teacher
                </option>

                <option value="attendance" {{ $permission->module == 'attendance' ? 'selected' : '' }}>
                    Attendance
                </option>

                <option value="fee" {{ $permission->module == 'fee' ? 'selected' : '' }}>
                    Fee
                </option>

                <option value="result" {{ $permission->module == 'result' ? 'selected' : '' }}>
                    Result
                </option>

                <option value="exam" {{ $permission->module == 'exam' ? 'selected' : '' }}>
                    Exam
                </option>

                <option value="academic" {{ $permission->module == 'academic' ? 'selected' : '' }}>
                    Academic
                </option>

            </select>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-success">
            Update Permission
        </button>

        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
            Back
        </a>

    </form>
</div>
@endsection
