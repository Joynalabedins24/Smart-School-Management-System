<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function create(Request $request)
    {
        $teacherAssignment = TeacherAssignment::with([
            'teacher.user',
            'class',
            'section',
            'subject',
            'academicSession',
            'schedules.classroom'
        ])->findOrFail($request->teacher_assignment_id);

        $classrooms = Classroom::where('status', 'active')
            ->orderBy('room_no')
            ->get();

        return view(
            'backend.Schedules.create',
            compact('teacherAssignment', 'classrooms')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'teacher_assignment_id' => 'required|exists:teacher_assignments,id',
            'classroom_id'          => 'required|exists:classrooms,id',
            'day'                   => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time'            => 'required|date_format:H:i',
            'end_time'              => 'required|date_format:H:i|after:start_time',
        ]);

        $assignment = TeacherAssignment::with([
            'teacher.user',
            'class',
            'section',
            'subject',
            'academicSession'
        ])->findOrFail($request->teacher_assignment_id);

    /*
    | Teacher Conflict
    */
        $teacherConflict = Schedule::whereHas('teacherAssignment', function ($query) use ($assignment) {
            $query->where('teacher_id', $assignment->teacher_id);
        })
        ->where('day', $request->day)
        ->where(function ($query) use ($request) {
            $query  ->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
        })
        ->exists();

        if ($teacherConflict) {
            return back()
                ->withInput()
                ->with('error', 'This teacher already has a class scheduled at this time.');
        }
    /*
    | Classroom Conflict
    */
        $roomConflict = Schedule::where('classroom_id', $request->classroom_id)
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query  ->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
            })
            ->exists();
        if ($roomConflict) {
            return back()
                ->withInput()
                ->with('error', 'This classroom is already booked at this time.');
        }


    /*
    | Create Schedule
    */
        DB::beginTransaction();
        try {
            Schedule::create([
            'teacher_assignment_id' => $assignment->id,
            'classroom_id' => $request->classroom_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            ]);
            DB::commit();
            return redirect()
                ->route('TeacherAssignments.index')
                ->with('success', 'Schedule added successfully!');
        } catch (\Exception $e) {

        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Failed to create schedule.');
        }
    }


    public function edit($id)
    {
        $schedule = Schedule::with([
        'teacherAssignment.teacher.user',
        'teacherAssignment.class',
        'teacherAssignment.section',
        'teacherAssignment.subject',
        'teacherAssignment.academicSession',
        'classroom'
        ])->findOrFail($id);

        $classrooms = Classroom::where('status', 'active')
        ->orderBy('room_no')
        ->get();

        return view(
        'backend.Schedules.edit',
        compact('schedule', 'classrooms')
        );
    }



    public function update(Request $request, $id)
    {
        $request->validate([
        'classroom_id' => 'required|exists:classrooms,id',
        'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $schedule = Schedule::with('teacherAssignment')
            ->findOrFail($id);

        $assignment = $schedule->teacherAssignment;


    /*
    | Teacher Conflict
    */
        $teacherConflict = Schedule::where('id', '!=', $schedule->id)
            ->whereHas('teacherAssignment', function ($query) use ($assignment) {
                $query->where(
                    'teacher_id',
                    $assignment->teacher_id
                );
            })
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query  ->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time );
            })
            ->exists();

        if ($teacherConflict) {
            return back()
            ->withInput()
            ->with(
                'error',
                'This teacher already has another class scheduled at this time.'
            );
        }


    /*
    | Classroom Conflict
    */
        $roomConflict = Schedule::where('classroom_id',$request->classroom_id)
        ->where('id', '!=', $schedule->id)
        ->where('day',$request->day)
        ->where(function ($query) use ($request) {
            $query->where(
                'start_time',
                '<',
                $request->end_time
            )
            ->where(
                'end_time',
                '>',
                $request->start_time
            );
        })
        ->exists();
        if ($roomConflict) {
            return back()
            ->withInput()
            ->with(
                'error',
                'This classroom is already booked at this time.'
            );
        }
    /*
    | Update Schedule
    */
        $schedule->update([
        'classroom_id' => $request->classroom_id,
        'day' => $request->day,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        ]);

        return redirect()
        ->route('TeacherAssignments.index')
        ->with(
            'success',
            'Schedule updated successfully!'
        );
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->delete();

        return  redirect()
                ->route('TeacherAssignments.index')
                ->with('success', 'Schedule deleted successfully!');
    }
}
