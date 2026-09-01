@extends('layouts.app')

@section('content')

<div class="shadow card col-10 mx-auto p-3">

    <div class="card-header bg-white border-0">
        <h5 class="fw-bold text-primary mb-1">
            <i class="fa-solid fa-calendar-pen me-2"></i>
            Edit Schedule
        </h5>

        <small class="text-muted">
            Update classroom schedule information
        </small>
    </div>


    {{-- Teacher Assignment Information --}}

    <div class="card shadow-sm border-0 bg-light mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">
                    <small class="text-muted">Teacher</small>
                    <div class="fw-bold">
                        {{ $schedule->teacherAssignment->teacher->user->name }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Class</small>
                    <div class="fw-bold">
                        {{ $schedule->teacherAssignment->class->name }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Section</small>
                    <div class="fw-bold">
                        {{ $schedule->teacherAssignment->section->name }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Subject</small>
                    <div class="fw-bold">
                        {{ $schedule->teacherAssignment->subject->name }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- Edit Schedule Form --}}

    <form action="{{ route('schedules.update', $schedule->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Classroom --}}

            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Classroom
                    <span class="text-danger">*</span>
                </label>

                <select name="classroom_id"
                        class="form-select"
                        required>

                    <option value="">
                        Select Classroom
                    </option>

                    @foreach($classrooms as $classroom)

                        <option value="{{ $classroom->id }}"
                            {{ $schedule->classroom_id == $classroom->id ? 'selected' : '' }}>

                            {{ $classroom->room_no }}
                            -
                            {{ $classroom->room_name }}

                        </option>

                    @endforeach

                </select>

                @error('classroom_id')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Day --}}

            <div class="col-md-4">

                <label class="form-label fw-semibold">
                    Day
                    <span class="text-danger">*</span>
                </label>

                <select name="day"
                        class="form-select"
                        required>

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
                            {{ $schedule->day == $day ? 'selected' : '' }}>

                            {{ $day }}

                        </option>

                    @endforeach

                </select>

                @error('day')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Start Time --}}

            <div class="col-md-2">

                <label class="form-label fw-semibold">
                    Start Time
                    <span class="text-danger">*</span>
                </label>

                <input type="time"
                       name="start_time"
                       class="form-control"
                       value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}"
                       min="00:00"
                       max="23:59"
                       step="60"
                       required>

                @error('start_time')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- End Time --}}

            <div class="col-md-2">

                <label class="form-label fw-semibold">
                    End Time
                    <span class="text-danger">*</span>
                </label>

                <input type="time"
                       name="end_time"
                       class="form-control"
                       value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}"
                       min="00:00"
                       max="23:59"
                       step="60"
                       required>

                @error('end_time')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Buttons --}}

            <div class="col-12 mt-4">

                <button type="submit"
                        class="btn btn-success">

                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Update Schedule

                </button>

                <a href="{{ route('TeacherAssignments.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Back

                </a>

            </div>

        </div>

    </form>

</div>

@endsection
