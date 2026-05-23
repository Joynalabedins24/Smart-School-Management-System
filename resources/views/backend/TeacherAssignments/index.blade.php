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

                            <th>Created At</th>
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
                                    {{ $assignment->created_at->format('d M Y') }}
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
