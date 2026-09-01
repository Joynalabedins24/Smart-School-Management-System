@extends('layouts.app')

@section('content')

<div class="shadow-sm card col-10 mx-auto p-3">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Set Class Schedule</h4>
            <small class="text-muted">
                Add a schedule for this teacher assignment
            </small>
        </div>

        <a href="{{ route('TeacherAssignments.index') }}"
           class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>


    {{-- Teacher Assignment Information --}}
    <div class="card border-primary mb-4">

        <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-link"></i>
            Teacher Assignment
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-2">
                    <small class="text-muted">Teacher</small>
                    <div class="fw-bold">
                        {{ $teacherAssignment->teacher->user->name }}
                    </div>
                </div>

                <div class="col-md-2 mb-2">
                    <small class="text-muted">Class</small>
                    <div class="fw-bold">
                        {{ $teacherAssignment->class->name }}
                    </div>
                </div>

                <div class="col-md-2 mb-2">
                    <small class="text-muted">Section</small>
                    <div class="fw-bold">
                        {{ $teacherAssignment->section->name }}
                    </div>
                </div>

                <div class="col-md-2 mb-2">
                    <small class="text-muted">Subject</small>
                    <div class="fw-bold">
                        {{ $teacherAssignment->subject->name }}
                    </div>
                </div>

                <div class="col-md-2 mb-2">
                    <small class="text-muted">Session</small>
                    <div class="fw-bold">
                        {{ $teacherAssignment->academicSession->name }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- Existing Schedules --}}
    @if($teacherAssignment->schedules->count())

    <div class="card border-warning mb-4">

        <div class="card-header bg-warning-subtle">

            <div class="d-flex justify-content-between align-items-center">

                <div class="fw-bold">
                    <i class="fa-solid fa-calendar-days"></i>
                    Existing Schedules
                </div>

                <span class="badge bg-primary">
                    {{ $teacherAssignment->schedules->count() }}
                    Schedule(s)
                </span>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($teacherAssignment->schedules as $key => $schedule)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    <span class="fw-bold">
                                        {{ $schedule->classroom->room_no }}
                                    </span>

                                    <br>

                                    <small class="text-muted">
                                        {{ $schedule->classroom->room_name }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $schedule->day }}
                                    </span>
                                </td>

                                <td>
                                    <i class="fa-regular fa-clock text-primary"></i>

                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}

                                    <span class="text-muted">--</span>

                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @else

    <div class="alert alert-secondary mb-4">

        <i class="fa-solid fa-calendar-xmark"></i>

        No schedule has been set for this teacher assignment yet.

    </div>

    @endif


    {{-- Schedule Form --}}
    <form action="{{ route('schedules.store') }}"
          method="POST"
          class="row g-3">

        @csrf

        {{-- teacherAssignment id --}}
        <input type="hidden"
               name="teacher_assignment_id"
               value="{{ $teacherAssignment->id }}">


        {{-- Classroom --}}
        <div class="col-md-6">

            <label class="form-label">
                Classroom <span class="text-danger">*</span>
            </label>

            <select name="classroom_id"
                    class="form-select @error('classroom_id') is-invalid @enderror"
                    required>

                <option value="">Select Classroom</option>

                @foreach($classrooms as $classroom)

                    <option value="{{ $classroom->id }}"
                        {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>

                        {{ $classroom->room_no }}
                        - {{ $classroom->room_name }}

                    </option>

                @endforeach

            </select>

            @error('classroom_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- Day --}}
        <div class="col-md-6">

            <label class="form-label">
                Day <span class="text-danger">*</span>
            </label>

            <select name="day"
                    class="form-select @error('day') is-invalid @enderror"
                    required>

                <option value="">Select Day</option>

                @foreach([
                    'Saturday',
                    'Sunday',
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday'
                ] as $day)

                    <option value="{{ $day }}"
                        {{ old('day') == $day ? 'selected' : '' }}>

                        {{ $day }}

                    </option>

                @endforeach

            </select>

            @error('day')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- Start Time --}}
        <div class="col-md-6">

            <label class="form-label">
                Start Time <span class="text-danger">*</span>
            </label>

            <input  type="time"
                    name="start_time"
                    value="{{ old('start_time') }}"
                    class="form-control @error('start_time') is-invalid @enderror"
                    min="00:00"
                    max="23:59"
                    step="60"
                    required>

            @error('start_time')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- End Time --}}
        <div class="col-md-6">

            <label class="form-label">
                End Time <span class="text-danger">*</span>
            </label>

            <input  type="time"
                    name="end_time"
                    value="{{ old('end_time') }}"
                    class="form-control @error('end_time') is-invalid @enderror"
                    min="00:00"
                    max="23:59"
                    step="60"
                    required>

            @error('end_time')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- Buttons --}}
        <div class="col-12 mt-4">

            <button type="submit"
                    class="btn btn-primary">

                <i class="fa-solid fa-calendar-plus"></i>
                Save Schedule

            </button>

            <a href="{{ route('TeacherAssignments.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection
