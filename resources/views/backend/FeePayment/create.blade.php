@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Receive Fee Payment</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('FeePayments.store') }}" method="POST">

                @csrf

                <div class="row mb-3">

                    <!-- Student Select -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Student
                        </label>

                        <select name="student_id"
                                id="student_id"
                                class="form-select">

                            <option value="">
                                Select Student
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}">

                                    {{ $student->user->name ?? '' }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Payment Method
                        </label>

                        <select name="payment_method"
                                class="form-select">

                            <option value="Cash">Cash</option>

                            <option value="Bkash">Bkash</option>

                            <option value="Nagad">Nagad</option>

                            <option value="Bank">
                                Bank
                            </option>

                        </select>

                    </div>

                    <!-- Payment Date -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Payment Date
                        </label>

                        <input type="date"
                               name="payment_date"
                               class="form-control"
                               value="{{ date('Y-m-d') }}">

                    </div>

                </div>

                <!-- AJAX Fee Load Area -->
                <div id="fee-area">

                    {{--

                        AJAX loaded unpaid fees here

                    --}}

                    {{--
                    Example Table:

                    | Checkbox | Fee Type | Month | Due |

                    --}}

                </div>

                <div class="row mt-4">

                    <!-- Total Pay Amount -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Pay Amount
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               step="0.01"
                               placeholder="Enter Payment Amount">

                    </div>

                    <!-- Transaction ID -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Transaction ID
                        </label>

                        <input type="text"
                               name="transaction_id"
                               class="form-control"
                               placeholder="Optional">

                    </div>

                    <!-- Note -->
                    <div class="col-md-4">

                        <label class="form-label">
                            Note
                        </label>

                        <input type="text"
                               name="note"
                               class="form-control"
                               placeholder="Optional">

                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-success">

                        Receive Payment

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

$(document).ready(function(){

    $('#student_id').on('change', function(){

        let student_id = $(this).val();

        if(student_id != ''){

            $.ajax({

                url: "{{ route('FeePayments.getFees') }}",

                type: "GET",

                data: {
                    student_id : student_id
                },

                success: function(response){

                    $('#fee-area').html(response);

                }

            });

        }
        else{

            $('#fee-area').html('');

        }

    });

});

</script>
@endsection
