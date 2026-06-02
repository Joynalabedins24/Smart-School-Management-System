@extends('layouts.app')

@section('content')

<div class="card p-3 col-10 mx-auto">

    <form method="GET" action="{{ route('promotions.index') }}">

        <div class="row">

            <!-- Current Session -->
            <div class="col-md-3">

                <div class="input-group mb-3">

                    <label class="input-group-text">
                        Session
                    </label>

                    <select name="from_session_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose...
                        </option>

                        @foreach($sessions as $session)

                            <option value="{{ $session->id }}"
                                {{ request('from_session_id') == $session->id ? 'selected' : '' }}>

                                {{ $session->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <!-- Current Class -->
            <div class="col-md-3">

                <div class="input-group mb-3">

                    <label class="input-group-text">
                        Class
                    </label>

                    <select name="from_class_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose...
                        </option>

                        @foreach($classes as $class)

                            <option value="{{ $class->id }}"
                                {{ request('from_class_id') == $class->id ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <!-- Next Session -->
            <div class="col-md-3">

                <div class="input-group mb-3">

                    <label class="input-group-text">
                        Next Session
                    </label>

                    <select name="to_session_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose...
                        </option>

                        @foreach($sessions as $session)

                            <option value="{{ $session->id }}"
                                {{ request('to_session_id') == $session->id ? 'selected' : '' }}>

                                {{ $session->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <!-- Next Class -->
            <div class="col-md-2">

                <div class="input-group mb-3">

                    <label class="input-group-text">
                        To
                    </label>

                    <select name="to_class_id"
                            class="form-select"
                            required>

                        <option value="">
                            Class
                        </option>

                        @foreach($classes as $class)

                            <option value="{{ $class->id }}"
                                {{ request('to_class_id') == $class->id ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="col-md-1">

                <button class="btn btn-primary w-100">

                    Load

                </button>

            </div>

        </div>

    </form>

</div>


@if($students->count() > 0)

<form method="POST"
      action="{{ route('promotions.process') }}">

    @csrf

    <input type="hidden"
           name="from_session_id"
           value="{{ request('from_session_id') }}">

    <input type="hidden"
           name="from_class_id"
           value="{{ request('from_class_id') }}">

    <input type="hidden"
           name="to_session_id"
           value="{{ request('to_session_id') }}">

    <input type="hidden"
           name="to_class_id"
           value="{{ request('to_class_id') }}">

    <div class="card p-3 col-10 mx-auto mt-3">

        <div class="row mb-3">

            <div class="col">

                <h4>

                    Student Promotion Wizard

                </h4>

            </div>

            <div class="col text-end">

                <button type="submit"
                        class="btn btn-success">

                    Process Promotion

                </button>

            </div>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Name</th>

                    <th>Student ID</th>

                    <th>Roll</th>

                    <th>Result</th>

                    <th>Total Due</th>

                    <th>Suggested Action</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($students as $student)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $student->student->user->name }}
                    </td>

                    <td>
                        {{ $student->student->student_id }}
                    </td>

                    <td>
                        {{ $student->roll_no ?? '-' }}
                    </td>

                    <td>

                        @if($student->result_status == 'Pass')

                            <span class="badge bg-success">
                                Pass
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Fail
                            </span>

                        @endif

                    </td>

                    <td>

                        ৳ {{ number_format($student->total_due, 2) }}

                    </td>

                    <td>

                        @if($student->promotion_action == 'promote')

                            <span class="badge bg-success">
                                Promote
                            </span>

                        @elseif($student->promotion_action == 'repeat')

                            <span class="badge bg-warning">
                                Repeat
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Hold
                            </span>

                        @endif

                    </td>

                    <td>

                        <select
                            name="students[{{ $student->student_id }}]"
                            class="form-select">

                            <option value="promote"
                                {{ $student->promotion_action == 'promote' ? 'selected' : '' }}>
                                Promote
                            </option>

                            <option value="repeat"
                                {{ $student->promotion_action == 'repeat' ? 'selected' : '' }}>
                                Repeat
                            </option>

                            <option value="hold"
                                {{ $student->promotion_action == 'hold' ? 'selected' : '' }}>
                                Hold
                            </option>

                        </select>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</form>

@endif

@endsection
