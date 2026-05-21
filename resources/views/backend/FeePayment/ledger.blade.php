@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>Student Ledger</h4>

        </div>

        <div class="card-body">

            <!-- Summary Cards -->
            <div class="row mb-4">

                <div class="col-md-4">

                    <div class="card border-primary">

                        <div class="card-body text-center">

                            <h5>Total Fees</h5>

                            <h4>
                                ৳ {{ number_format($totalFees, 2) }}
                            </h4>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-success">

                        <div class="card-body text-center">

                            <h5>Total Paid</h5>

                            <h4>
                                ৳ {{ number_format($totalPaid, 2) }}
                            </h4>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-danger">

                        <div class="card-body text-center">

                            <h5>Total Due</h5>

                            <h4>
                                ৳ {{ number_format($totalDue, 2) }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Ledger Table -->
            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Fee Type</th>

                            <th>Month</th>

                            <th>Total</th>

                            <th>Paid</th>

                            <th>Due</th>

                            <th>Status</th>

                            <th>Receipt</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($fees as $fee)

                            @php

                                $paid = $fee->payments->sum('amount');

                                $due = ($fee->total_amount + $fee->late_fee)
                                        - $paid;

                            @endphp

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $fee->fee_type }}
                                </td>

                                <td>
                                    {{ $fee->month }}
                                    -
                                    {{ $fee->year }}
                                </td>

                                <td>
                                    ৳ {{ number_format($fee->total_amount + $fee->late_fee, 2) }}
                                </td>

                                <td>
                                    ৳ {{ number_format($paid, 2) }}
                                </td>

                                <td>
                                    ৳ {{ number_format($due, 2) }}
                                </td>

                                <td>

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

                                </td>

                                <td>

                                    @if($fee->payments->count() > 0)

                                        <a href="{{ route(
                                                'FeePayments.receipt',
                                                $fee->payments->last()->receipt_no
                                            ) }}"
                                           class="btn btn-info btn-sm">

                                            Receipt {{ $fee->payments->last()->receipt_no }}

                                        </a>

                                    @else

                                        N/A

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
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
