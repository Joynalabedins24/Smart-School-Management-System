@extends('layouts.app')
@section('content')
<div class="col-11 mx-auto" >
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>Fee Details</h4>

            <a href="{{ route('Fees.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>

        </div>

        <div class="card-body">

            @php

                $paid = $fee->payments->sum('amount');

                $due = ($fee->total_amount + $fee->late_fee) - $paid;

            @endphp

            <!-- Student Information -->
            <div class="row mb-4">

                <div class="col-md-6">
                    <strong>Student Name :</strong>
                    {{ $fee->student->user->name ?? '' }}
                </div>

                <div class="col-md-6">
                    <strong>Class :</strong>
                    {{ $fee->student->class->name ?? '' }}
                </div>

            </div>

            <!-- Fee Information -->
            <div class="row mb-4">

                <div class="col-md-6">
                    <strong>Fee Type :</strong>
                    {{ ucwords($fee->fee_type) }}
                </div>

                <div class="col-md-6">
                    <strong>Month :</strong>
                    {{ \Carbon\Carbon::parse($fee->month)->format('F Y') }}
                </div>

            </div>

            <!-- Financial Information -->
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Total Amount :</strong><br>
                    ৳ {{ number_format($fee->total_amount, 2) }}
                </div>

                <div class="col-md-3">
                    <strong>Late Fee :</strong><br>
                    ৳ {{ number_format($fee->late_fee, 2) }}
                </div>

                <div class="col-md-3">
                    <strong>Paid Amount :</strong><br>
                    ৳ {{ number_format($paid, 2) }}
                </div>

                <div class="col-md-3">
                    <strong>Due Amount :</strong><br>
                    ৳ {{ number_format($due, 2) }}
                </div>

            </div>

            <!-- Status -->
            <div class="mb-4">

                <strong>Status :</strong>

                @if($fee->status == 'paid')

                    <span class="badge bg-success">
                        Paid
                    </span>

                @elseif($fee->status == 'partial')

                    <span class="badge bg-warning">
                        Partial
                    </span>

                @else

                    <span class="badge bg-danger">
                        Unpaid
                    </span>

                @endif

            </div>

            <!-- Payment History -->
            <div class="card mt-4">

                <div class="card-header">
                    <h5>Payment History</h5>
                </div>

                <div class="card-body p-0">

                    <table class="table table-bordered mb-0">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($fee->payments as $payment)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        ৳ {{ number_format($payment->amount, 2) }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center text-danger">

                                        No Payment Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
        </div>
@endsection
