<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Validator;
use DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'schedules.name');
        $orderDirection = $request->query('sort_order', 'desc');

        $schedules = Schedule::with(['teacher', 'class', 'course', 'schoolYear'])
            ->whereHas('teacher', function ($x) use ($search) {
                $x->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('class', function ($x) use ($search) {
                $x->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('course', function ($x) use ($search) {
                $x->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhere('day', 'LIKE', '%' . $search . '%');

        $schedules = $schedules->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListScheduleResource::collection($schedules);
    }

    public function show($id)
    {
        $schedule = Schedule::with(['teacher', 'course', 'class', 'schoolYear'])->find($id);

        return response()->json($schedule);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required',
            'teacher' => 'required',
            'course' => 'required',
            'school_year' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $schedule = new Schedule();
        $schedule->class_id = $request->class[0]['id'];
        $schedule->nip = $request->teacher[0]['nip'];
        $schedule->course_id = $request->course[0]['id'];
        $schedule->school_year_id = $request->school_year;
        $schedule->day = $request->day;
        $schedule->start_time = date("H:i:s", strtotime($request->start_time));
        $schedule->end_time = date("H:i:s", strtotime($request->end_time));
        $schedule->save();

        return response()->json($schedule);
    }

    public function update($id, Request $request)
    {
        $schedule = Schedule::find($id);

        $validator = Validator::make($request->all(), [
            'class' => 'required',
            'teacher' => 'required',
            'course' => 'required',
            'school_year' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $schedule->class_id = $request->class[0]['id'];
        $schedule->nip = $request->teacher[0]['nip'];
        $schedule->course_id = $request->course[0]['id'];
        $schedule->school_year_id = $request->school_year;
        $schedule->day = $request->day;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->save();

        return response()->json($schedule);
    }

    public function delete($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();

        return response()->json($schedule);
    }

    public function getScheduleByNip(Request $request, $nip)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'schedules.name');
        $orderDirection = $request->query('sort_order', 'desc');

        $schedules = Schedule::with(['teacher', 'class', 'course', 'schoolYear'])
            ->where(function ($x) use ($search) {
                $x->whereHas('teacher', function ($x) use ($search) {
                    $x->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('class', function ($x) use ($search) {
                    $x->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('course', function ($x) use ($search) {
                    $x->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('day', 'LIKE', '%' . $search . '%');
            })
            ->where('nip', $nip);

        $schedules = $schedules->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListScheduleResource::collection($schedules);
    }
}
