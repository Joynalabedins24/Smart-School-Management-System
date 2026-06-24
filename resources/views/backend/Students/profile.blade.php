@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4>Student Profile</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>
                        <strong>Name:</strong>
                        {{ $student->user->name }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ $student->user->email }}
                    </p>

                    <p>
                        <strong>Student ID:</strong>
                        {{ $student->student_id }}
                    </p>

                    <p>
                        <strong>Gender:</strong>
                        {{ $student->gender }}
                    </p>

                </div>

                <div class="col-md-6">

                    <p>
                        <strong>Guardian:</strong>
                        {{ $student->guardian_name }}
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        {{ $student->guardian_phone }}
                    </p>

                    <p>
                        <strong>DOB:</strong>
                        {{ $student->dob }}
                    </p>

                    <p>
                        <strong>Address:</strong>
                        {{ $student->address }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
