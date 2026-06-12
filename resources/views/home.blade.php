@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-primary text-white shadow-sm mb-2">
        <div class="card-body">

            <h3 class="mb-1">
                Welcome, {{ Auth::user()->name }} 👋
            </h3>

            <p class="mb-0">
                Active Session:
                {{ $activeSession->name ?? 'N/A' }}
            </p>

        </div>
    </div>


    <div class="row">

    <!-- Students -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">

                <div class="me-3">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>

                <div>
                    <h3 class="mb-0">{{ $totalStudents }}</h3>
                    <small class="text-muted">
                        Total Students
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- Teachers -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">

                <div class="me-3">
                    <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                </div>

                <div>
                    <h3 class="mb-0">{{ $totalTeachers }}</h3>
                    <small class="text-muted">
                        Total Teachers
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- Classes -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">

                <div class="me-3">
                    <i class="fas fa-school fa-3x text-warning"></i>
                </div>

                <div>
                    <h3 class="mb-0">{{ $totalClasses }}</h3>
                    <small class="text-muted">
                        Total Classes
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- Subjects -->
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">

                <div class="me-3">
                    <i class="fas fa-book fa-3x text-danger"></i>
                </div>

                <div>
                    <h3 class="mb-0">{{ $totalSubjects }}</h3>
                    <small class="text-muted">
                        Total Subjects
                    </small>
                </div>

            </div>
        </div>
    </div>

    </div>




    <div class="row">

        <!-- Collection -->
        <div class="col-lg-4 col-md-6 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                <h6 class="text-success">
                    Total Collection
                </h6>

                <h2>
                    ৳ {{ number_format($totalCollected, 2) }}
                </h2>

                </div>

            </div>

        </div>

        <!-- Due -->
        <div class="col-lg-4 col-md-6 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                <h6 class="text-danger">
                    Total Due
                </h6>

                <h2>
                    ৳ {{ number_format($totalDue, 2) }}
                </h2>

                </div>

            </div>

        </div>

        <!-- Attendance -->
        <div class="col-lg-4 col-md-12 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                <h6 class="text-primary">
                    Attendance Rate
                </h6>

                <h2>
                    {{ $attendancePercentage }}%
                </h2>

                </div>

            </div>

        </div>

    </div>




</div>
@endsection
