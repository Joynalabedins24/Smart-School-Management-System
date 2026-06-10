@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <form method="POST" action="{{ route('permissions.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Permission name" class="form-control">

        <select name="module" class="form-control mt-2">
            <option value="">Select Module</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="attendance">Attendance</option>
            <option value="fee">Fee</option>
            <option value="result">Result</option>
        </select>

        <button class="btn btn-primary mt-2">Save</button>
    </form>
</div>
@endsection
