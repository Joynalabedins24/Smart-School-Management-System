




<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>

    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #eee;
        }



        .mycontainer {
            display: flex;
        }
        .mycontainer > div {
            width:33%;
        }

        .center{
            text-align: center;
        }
        .right{
            text-align: Right;
        }

        .m-5{
            margin: 5px;
        }


    </style>
</head>

<body style =" margin: 50px">

<div>

    <div>

        <div class="center">
            <h2>Childs Haven international School & College</h2>
            <h4>Attendance Report</h4>
        </div>

    </div>


    <div class="mycontainer m-5">

        <div>
            Date: {{ \Carbon\Carbon::parse($date)->format('jS F Y') }}
        </div>

        <div class="">
            Class : {{ $classe->name ?? '' }}
        </div>

        <div class="">
            Section : {{ $section->name ?? '' }}
        </div>
    </div>


    <!-- RESULT TABLE -->
    @if(count($students) > 0)

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>

        <tbody>
        @foreach($students as $key => $student)

            @php
                $attendance = $student->attendances->first();
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->student_id }}</td>

                <td style =
                            @if($attendance && $attendance->status == 'present')
                                "background-color:MediumSeaGreen;"
                            @else
                                "background-color:Tomato;"
                            @endif
                            >
                    @if($attendance && $attendance->status == 'present')
                        <span class="badge bg-success">Present</span>
                    @else
                        <span class="badge bg-danger">Absent</span>
                    @endif
                </td>

                <td>
                    {{ $attendance->remarks ?? '-' }}
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    @else
        <p class="text-center text-muted">No data found</p>
    @endif

    <div class="m-5">

        <div class=" text-start">
            Total Student : {{ $totalStudent }}

        </div>

        <div class=" text-start">
            Present : {{ $present ?? '' }}

        </div>

        <div class=" text-start">
            Absent : {{ $absent ?? '' }}

        </div>
        <div class=" text-start">
            Attendance : {{ $percentage ?? '' }}%

        </div>

    </div>


</div>

</body>
</html>
