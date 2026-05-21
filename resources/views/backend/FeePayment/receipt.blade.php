@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-body">

            <!-- Print Button -->
            <div class="mb-3 text-end no-print">
                <button
                        class="btn btn-primary">


                    <a class="dropdown-item" href="{{ route('FeePayments.index') }}">Back to Payment History</a>
                </button>

                <button onclick="window.print()"
                        class="btn btn-primary">

                    Print Receipt

                </button>

            </div>

            @php

                $student = $payments->first()->fee->student;

                $totalPaid = $payments->sum('amount');

            @endphp

            <!-- School Info -->
            <div class="text-center mb-4">

                <h2>Your School Name</h2>

                <p>School Address Here</p>

                <h4 class="mt-3">
                    PAYMENT RECEIPT
                </h4>

            </div>

            <!-- Receipt Info -->
            <div class="row mb-4">

                <div class="col-md-6">

                    <strong>Receipt No :</strong>

                    {{ $receipt_no }}

                </div>

                <div class="col-md-6 text-end">

                    <strong>Date :</strong>

                    {{ \Carbon\Carbon::parse($payments->first()->payment_date)->format('d M Y') }}

                </div>

            </div>

            <!-- Student Info -->
            <div class="row mb-4">

                <div class="col-md-6">

                    <strong>Student Name :</strong>

                    {{ $student->user->name ?? '' }}

                </div>

                <div class="col-md-6">

                    <strong>Class :</strong>

                    {{ $student->classroom->name ?? '' }}

                </div>

            </div>

            <!-- Payment Table -->
            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Fee Type</th>

                        <th>Month</th>

                        <th>Amount</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($payments as $payment)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $payment->fee->fee_type }}
                            </td>

                            <td>
                                {{ $payment->fee->month }}
                                -
                                {{ $payment->fee->year }}
                            </td>

                            <td>
                                ৳ {{ number_format($payment->amount, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot>

                    <tr>

                        <th colspan="3"
                            class="text-end">

                            Total Paid

                        </th>

                        <th>

                            ৳ {{ number_format($totalPaid, 2) }}

                        </th>

                    </tr>

                </tfoot>

            </table>

            <!-- Payment Details -->
            <div class="row mt-4">

                <div class="col-md-6">

                    <strong>Payment Method :</strong>

                    {{ $payments->first()->payment_method }}

                </div>

                <div class="col-md-6">

                    <strong>Transaction ID :</strong>

                    {{ $payments->first()->transaction_id ?? 'N/A' }}

                </div>

            </div>

            <!-- Signature -->
            <div class="row mt-5">

                <div class="col-md-6 text-center">

                    ______________________

                    <br>

                    Accountant Signature

                </div>

                <div class="col-md-6 text-center">

                    ______________________

                    <br>

                    Authorized Signature

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@section('css')

<style>

@media print {

    .no-print {

        display: none;

    }

}

</style>

@endsection
