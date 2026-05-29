@extends('layouts.app')
@section('content')
        <div class= "bg-gray  col-11 mx-auto mb-2" >
            <div>
                <h3 class="text-center">Fee List</h3>
            </div>
            <div> <a class="btn btn-primary" href="{{ route('Fees.create') }}"><i class="fa-regular fa-square-plus"></i> Add Fees</a></div>
        </div>

        <div class="col-11 mx-auto" >

            <form method="GET" class="input-group" action="{{ route('Fees.index') }}" >

            <!-- Search -->
            <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or ID..."
                    class="form-control ">

            <!-- Filter -->
            <select name="class_id" class="form-select ">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}"
                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
                </option>
                @endforeach
            </select>



            <select name="fee_type" class="form-select ">
                <option value="">All Fee Types</option>
                <option value="monthly fee" {{ request('fee_type') == 'monthly fee' ? 'selected' : '' }}>
                    Monthly Fee
                </option>

                <option value="exam fee" {{ request('fee_type') == 'exam fee' ? 'selected' : '' }}>
                    Exam Fee
                </option>
                <option value="lab fee" {{ request('fee_type') == 'lab fee' ? 'selected' : '' }}>
                    Lab Fee
                </option>
            </select>




            <input type="month" name="month" class="form-control" value="{{ request('month') }}">

            <select  name="status" class="form-select">
                <option value="">All Status</option>

                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                    Paid
                </option>
                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>
                    Partial
                </option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>
                    Unpaid
                </option>
            </select>

            <button class="btn btn-primary">Apply</button>

            <a href="{{ route('Fees.index') }}" class="btn btn-secondary">Reset</a>

            </form>

        </div>


    <div class="shadow-sm card col-11 mx-auto">
        <div class="card">
            <div class="card-header">
              All Fees
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Class</th>
                        <th scope="col">Fee Type</th>
                        <th scope="col">Month</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Due</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($fees as $key => $fee)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $fee->studentSession->student->user->name }}</td>
                            <td>{{ $fee->studentSession->student->student_id }}</td>
                            <td>{{ $fee->studentSession->class->name }}</td>
                            <td>{{ $fee->fee_type }}</td>
                            <td>{{ $fee->month }}</td>
                            <td>{{ $fee->due_date }}</td>
                            <td>৳ {{ number_format($fee->total_amount, 2) }}</td>
                            <td>৳ {{ number_format($fee->late_fee, 2) }}</td>
                            @php

                            $paid = $fee->payments->sum('amount');

                            $due = ($fee->total_amount + $fee->late_fee) - $paid;

                            @endphp
                            <td>
                                {{ $due }}
                            </td>
                            <td>
                                @if($fee->status == 'paid')

                                    <span class="badge bg-success">Paid</span>

                                @elseif($fee->status == 'partial')

                                    <span class="badge bg-warning">Partial</span>

                                @else

                                    <span class="badge bg-danger">Unpaid</span>

                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-primary fw-bold" href="{{ route('Fees.show', $fee->id) }}"> View </a>
                                        <a class="btn btn-sm btn-outline-success  fw-bold" href=""> Pay </a>
                                    @if($fee->payments->count() == 0)
                                        <a class="btn btn-sm btn-outline-warning  fw-bold" href="{{ route('Fees.edit', $fee->id) }}"> Edit </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $fees->links() }}
            </div>
        </div>


    </div>
    @if(
    request('class_id') &&
    request('fee_type') &&
    request('month')
    )

    <div class="shadow-sm card col-11 mx-auto">
        <form action="{{ route('Fees.bulkDelete') }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <input type="hidden"
                    name="class_id"
                    value="{{ request('class_id') }}">

                    <input type="hidden"
                    name="fee_type"
                    value="{{ request('fee_type') }}">

                    <input type="hidden"
                    name="month"
                    value="{{ request('month') }}">

                    <button class="btn btn-outline-danger w-100">

                        Bulk Delete

                    </button>

        </form>
    </div>

    @endif






@endsection
