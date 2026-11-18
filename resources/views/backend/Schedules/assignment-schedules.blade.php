
@extends('layouts.app')

@section('content')
<div class="container">
    

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Assignment Schedule Details</h4>
            <p class="text-muted mb-0">
                All schedules under this teacher assignment
            </p>
        </div>

        <a href="{{ route('TeacherAssignments.index') }}"
           class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Assignment Information --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Assignment Information</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <strong>Teacher:</strong>
                    {{ $teacherAssignment->teacher->user->name ?? 'N/A' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Class:</strong>
                    {{ $teacherAssignment->class->name ?? 'N/A' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Section:</strong>
                    {{ $teacherAssignment->section->name ?? 'N/A' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Subject:</strong>
                    {{ $teacherAssignment->subject->name ?? 'N/A' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Academic Session:</strong>
                    {{ $teacherAssignment->academicSession->name ?? 'N/A' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Total Schedules:</strong>
                    <span class="badge bg-primary">
                        {{ $schedules->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Schedule List --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Schedules</h5>

            <a href="{{ route('schedules.create', [
                'teacher_assignment_id' => $teacherAssignment->id
            ]) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Schedule
            </a>
        </div>

        <div class="card-body">
            @if($schedules->count() > 0)

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Classroom</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($schedules as $key => $schedule)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $schedule->day }}</td>

                                    <td>
                                        {{ $schedule->start_time->format('h:i A') }}
                                    </td>

                                    <td>
                                        {{ $schedule->end_time->format('h:i A') }}
                                    </td>

                                    <td>
                                        {{ $schedule->classroom->room_no ?? 'N/A' }}
                                        -
                                        {{ $schedule->classroom->room_name ?? '' }}
                                    </td>

                                    <td>
                                        @if($schedule->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('schedules.edit', $schedule->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('schedules.destroy', $schedule->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this schedule?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="text-center py-5">
                    <h5 class="text-muted">No Schedule Found</h5>
                    <p class="text-muted">
                        No schedule has been added to this assignment yet.
                    </p>

                    <a href="{{ route('schedules.create', [
                        'teacher_assignment_id' => $teacherAssignment->id
                    ]) }}" class="btn btn-primary">
                        Add First Schedule
                    </a>
                </div>
            @endif
        </div>
    </div>
    

</div>
@endsection
