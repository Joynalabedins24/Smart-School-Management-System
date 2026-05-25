@extends('layouts.app')
@section('content')
    <div class="col-11 mx-auto" >
        @php
            $currentMonth = \Carbon\Carbon::parse($month);

            $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
            $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Previous -->
            <a href="{{ route('attendance.calendar', ['id' => $student->id, 'month' => $prevMonth]) }}"
                class="btn btn-outline-primary">
                ⬅️ Previous
            </a>

            <!-- Current Month -->
            <h5>
                {{ $currentMonth->format('F Y') }}
            </h5>


            <!-- Next -->
            @if($currentMonth->lt(now()))
            <a href="{{ route('attendance.calendar', ['id' => $student->id, 'month' => $nextMonth]) }}"
                class="btn btn-outline-primary">
                Next ➡️
            </a>
            @endif


        </div>

    </div>


    <div class="shadow-sm card col-11 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $student->user->name }} -
                    {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                </h4>
            </div>
            <div class="card-body">
                <h4>

                </h4>

                @php
                use Carbon\Carbon;

                $start = Carbon::parse($month)->startOfMonth();
                $end = Carbon::parse($month)->endOfMonth();

                $startDay = $start->dayOfWeek; // 0=Sunday

                    @endphp

                <table width="" class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                <tbody style="font-weight: bold;">

                    <tr>

                    {{-- Empty cells before month start --}}
                    @for ($i = 0; $i < $startDay; $i++)
                        <td></td>
                    @endfor

                    {{-- Days loop --}}
                    @for ($date = $start->copy(); $date <= $end; $date->addDay())

                        @php
                            $key = $date->format('Y-m-d');
                            $status = $attendances[$key]->status ?? null;
                            $isToday = $date->isToday();

                            $color = '';
                            if ($status == 'present') $color = 'bg-success text-white';
                            elseif ($status == 'absent') $color = 'bg-danger text-white';
                        @endphp

                        <td class="{{ $color }} {{ $isToday ? 'border border-dark-subtle border-4' : '' }}"
                            title="{{ $status ?? 'No data' }}"
                            onclick="showDetails(
                                    '{{ $date->format('d M Y') }}',
                                    '{{ $status ?? 'No data' }}',
                                    '{{ $attendances[$key]->remarks ?? '-' }}')"
                                    style="cursor:pointer;">
                                {{ $date->format('d') }}
                        </td>

                        {{-- New row every Saturday --}}
                    @if ($date->dayOfWeek == 6)
                    </tr>
                    <tr>
                    @endif

                    @endfor

                    {{-- Fill remaining cells --}}
                    @php
                        $remaining = 6 - $end->dayOfWeek;
                    @endphp

                        @for ($i = 0; $i < $remaining; $i++)
                        <td></td>
                        @endfor

                    </tr>

                </tbody>
                </table>
            </div>

            <!-- Legend -->
            <div class="d-flex align-items-center gap-4 mb-3 ms-3">

                <div class="d-flex align-items-center gap-1">
                    <div style="width:15px; height:15px; background:green;"></div>
                    <small>Present</small>
                </div>

                <div class="d-flex align-items-center gap-1">
                    <div style="width:15px; height:15px; background:red;"></div>
                    <small>Absent</small>
                </div>

                <div class="d-flex align-items-center gap-1">
                    <div style="width:15px; height:15px; border:1px solid ; background:white;"></div>
                    <small>No Data</small>
                </div>

            </div>



        </div>

    </div>




    <!-- Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Date:</strong> <span id="modalDate"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Remarks:</strong> <span id="modalRemarks"></span></p>
                </div>

            </div>
        </div>
    </div>
    <script>
    function showDetails(date, status, remarks) {

    document.getElementById('modalDate').innerText = date;
    document.getElementById('modalStatus').innerText = status;
    document.getElementById('modalRemarks').innerText = remarks;

    let modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
    modal.show();
    let statusEl = document.getElementById('modalStatus');
        if(status === 'present'){
        statusEl.style.color = 'green';
        } else if(status === 'absent'){
        statusEl.style.color = 'red';
        }
    }
    </script>
@endsection















