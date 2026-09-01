@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Teacher Assignments</h4>

            <a href="{{ route('TeacherAssignments.create') }}"
               class="btn btn-primary">

                Add Assignment

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Teacher</th>

                            <th>Class</th>

                            <th>Section</th>

                            <th>Subject</th>

                            <th>Session</th>

                            <th>Shedules</th>

                            <th width="180"> Action </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($assignments as $assignment)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $assignment->teacher->user->name ?? '' }}
                                </td>

                                <td>
                                    {{ $assignment->class->name ?? '' }}
                                </td>

                                <td>
                                    {{ $assignment->section->name ?? '' }}
                                </td>

                                <td>
                                    {{ $assignment->subject->name ?? '' }}
                                </td>

                                <td>
                                    {{ $assignment->academicSession->name ?? '' }}
                                </td>

                                <td>
                                @if($assignment->schedules->count())
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th>Room No.</th>
                                            <th>Day</th>
                                            <th>Time</th>
                                            <td align="right"> Action </td>
                                        </tr>
                                        @foreach ($assignment->schedules  as $schedule)
                                            <tr>
                                                <td> {{ $schedule->classroom->room_no }} </td>
                                                <td> {{ $schedule->day }}</td>
                                                <td> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -- {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                                <td align="right">
                                                    <a  href="{{ route('schedules.edit',$schedule->id) }}"
                                                        class="btn btn-sm btn-outline-warning"
                                                        title="Edit Schedule">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    {{-- Delete --}}
                                                    <form class="d-inline"  action="{{ route('schedules.destroy', $schedule->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Delete Schedule">

                                                                <i class="fa-solid fa-trash"></i>

                                                            </button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>
                                    <a style="margin-top: 0px; width:100%;" href="{{ route('schedules.create', ['teacher_assignment_id' => $assignment->id]) }}" class="btn btn-sm btn-primary ">
                                        Add Schedule
                                    </a>
                                @else
                                    <span class="badge bg-secondary">
                                        Schedule Not Set
                                    </span>
                                    <a style="float: right;" href="{{ route('schedules.create', ['teacher_assignment_id' => $assignment->id])}}" class="btn btn-sm btn-primary">
                                        Set Schedule
                                    </a>
                                @endif
                                </td>
                                <td>

                                    <a  href="{{ route('TeacherAssignments.edit',$assignment->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form   action="{{ route('TeacherAssignments.destroy',$assignment->id) }}"
                                            method="POST"
                                            style="display:inline-block;">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                    Delete
                                        </button>

                                    </form>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-danger">

                                    No Assignment Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
