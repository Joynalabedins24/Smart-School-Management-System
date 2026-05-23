@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Student Sessions</h4>

            <a href="{{ route('StudentSessions.create') }}"
               class="btn btn-primary">

                Add Student Session

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Student</th>

                            <th>Class</th>

                            <th>Academic Session</th>

                            <th>Created At</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($studentSessions as $studentSession)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $studentSession->student->user->name ?? '' }}
                                </td>

                                <td>
                                    {{ $studentSession->class->name ?? '' }}
                                </td>

                                <td>
                                    {{ $studentSession->academicSession->name ?? '' }}
                                </td>

                                <td>
                                    {{ $studentSession->created_at->format('d M Y') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-danger">

                                    No Records Found

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
