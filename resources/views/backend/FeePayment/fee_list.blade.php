@if($fees->count() > 0)

<table class="table table-bordered">

    <thead>

        <tr>

            <th>Select</th>

            <th>Fee Type</th>

            <th>Month</th>

            <th>Total</th>

            <th>Paid</th>

            <th>Due</th>

        </tr>

    </thead>

    <tbody>

        @foreach($fees as $fee)

            @php

                $paid = $fee->payments->sum('amount');

                $due = ($fee->total_amount + $fee->late_fee) - $paid;

            @endphp

            <tr>

                <td>

                    <input type="checkbox"
                           name="fee_ids[]"
                           value="{{ $fee->id }}">

                </td>

                <td>
                    {{ $fee->fee_type }}
                </td>

                <td>
                    {{ $fee->month }} - {{ $fee->year }}
                </td>

                <td>
                    {{ $fee->total_amount }}
                </td>

                <td>
                    {{ $paid }}
                </td>

                <td>
                    {{ $due }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

@else

<div class="alert alert-danger">

    No Unpaid Fees Found

</div>

@endif
