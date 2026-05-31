@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4>Payment History</h4>

            <a href="{{ route('FeePayments.create') }}"
               class="btn btn-primary btn-sm">

                Receive Payment

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Student</th>

                            <th>Fee Type</th>

                            <th>Amount</th>

                            <th>Method</th>

                            <th>Transaction ID</th>

                            <th>Date</th>

                            <th class="col-2">Receipt </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payments as $payment)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $payment->fee->studentSession->student->user->name ?? '' }}
                                </td>

                                <td>
                                    {{ $payment->fee->fee_type ?? '' }}
                                </td>

                                <td>
                                    ৳ {{ number_format($payment->amount, 2) }}
                                </td>

                                <td>
                                    {{ $payment->payment_method }}
                                </td>

                                <td>
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('FeePayments.receipt',$payment->receipt_no) }}"class="btn btn-info btn-sm">
                                        Receipt {{ $payment->receipt_no ?? 'N/A' }}
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center text-danger">

                                    No Payment Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $payments->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
