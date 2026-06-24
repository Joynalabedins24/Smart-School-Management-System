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


    <div class="row">
    <!-- Monthly Fee Collection -->
    <div class="col-6">
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
            Monthly Fee Collection
            </h5>
        </div>

        <div class="card-body">
            <canvas id="feeChart"></canvas>
        </div>
        <div class="shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Recent Fee Collections
            </h5>
        </div>

        <div class="card-body p-0">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>
                        <th>Receipt</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($recentPayments as $payment)

                    <tr>

                        <td>
                            {{ $payment->receipt_no }}
                        </td>

                        <td>
                            ৳ {{ number_format($payment->amount,2) }}
                        </td>

                        <td>
                            {{ ucfirst($payment->payment_method) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            No Payments Found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
    </div>

    </div>


    <!-- Recent Addmision -->

    <div class="col-6">
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
            Recent Admissions
            </h5>

        </div>

        <div class="card-body p-0 ">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Guardian</th>
                        <th>Phone</th>
                        <th>Admission Date</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($recentAdmissions as $student)

                    <tr>

                        <td>
                            {{ $student->student_id }}
                        </td>

                        <td>
                            {{ $student->user->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $student->guardian_name }}
                        </td>

                        <td>
                            {{ $student->guardian_phone }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($student->admission_date)->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            No Recent Admissions Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>
        </div>
    </div>
            <!--Attendance Summery-->
            <div class="card shadow-sm mt-2">

                <div class="card-header">
                    <h5 class="mb-0">
                        Today's Attendance'
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-4">
                            <h3 class="text-success">
                            {{ $presentCount }}
                            </h3>
                            <p>Present</p>
                        </div>

                        <div class="col-md-4">
                            <h3 class="text-danger">
                                {{ $absentCount }}
                            </h3>
                            <p>Absent</p>
                        </div>

                        <div class="col-md-4">
                            <h3 class="text-warning">
                                {{ $lateCount }}
                            </h3>
                            <p>Late</p>
                        </div>

                    </div>

                </div>

            </div>
            <div class="card shadow-sm mt-2">

                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>

                <div class="card-body">

                    <div class="d-grid gap-2">

                        @can('Add student')
                        <a href="{{ route('student.create') }}"
                            class="btn btn-primary">
                            Add Student
                        </a>
                        @endcan

                        @can('manage fees')
                        <a href="{{ route('FeePayments.create') }}"
                            class="btn btn-success">
                            Collect Fee
                        </a>
                        @endcan

                        @can('Manage attendance')
                        <a href="{{ route('attendance.create') }}"
                            class="btn btn-warning">
                            Take Attendance
                        </a>
                        @endcan

                        @can('Manage result')
                        <a href="{{ route('results.create') }}"
                            class="btn btn-info">
                            Add Result
                        </a>
                        @endcan

                    </div>

                </div>

            </div>
    </div>
    </div>


    @role('admin')

<div class="card shadow-sm mt-2">

    <div class="card-header">
        <h5 class="mb-0">
            Recent Registered Users
        </h5>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>

            <tbody>

            @forelse($recentUsers as $user)

                <tr>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>

                        @foreach($user->roles as $role)

                            <span class="badge bg-primary">
                                {{ $role->name }}
                            </span>

                        @endforeach

                    </td>

                    <td>
                        {{ $user->created_at->diffForHumans() }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center">
                        No Users Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endrole





</div>




</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chartData = @json($chartData);

const ctx =
    document.getElementById('feeChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: chartData.map(
            item => item.month
        ),

        datasets: [{

            label: 'Fee Collection',

            data: chartData.map(
                item => item.total
            ),

            borderWidth: 3,

            tension: 0.4,

            fill: true

        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: true
            }

        }

    }

});
</script>
@endsection
