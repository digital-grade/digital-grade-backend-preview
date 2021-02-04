<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\ListTeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'name');
        $orderDirection = $request->query('sort_order', 'desc');

        $teachers = Teacher::where('nip', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%');

        $teachers = $teachers->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListTeacherResource::collection($teachers);
    }

    public function show($nip)
    {
        $teacher = Teacher::where('nip', $nip)->first();

        return response()->json($teacher);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required|string',
            'blood_type' => 'required|string',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'profile_picture_url' => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $teacher = new Teacher();
        $teacher->nip = $request->nip;
        $teacher->name = $request->name;
        $teacher->phone_number = $request->phone_number;
        $teacher->place_of_birth = $request->place_of_birth;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->blood_type = $request->blood_type;
        $teacher->email = $request->email;
        $teacher->save();

        return response()->json($teacher);
    }

    public function update($nip, Request $request)
    {
        $teacher = Teacher::whereNip($nip)->first();

        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required|string',
            'blood_type' => 'required|string',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'profile_picture_url' => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $teacher->nip = $request->nip;
        $teacher->name = $request->name;
        $teacher->phone_number = $request->phone_number;
        $teacher->place_of_birth = $request->place_of_birth;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->blood_type = $request->blood_type;
        $teacher->email = $request->email;
        $teacher->save();

        return response()->json($teacher);
    }

    public function delete($nip)
    {
        $teacher = Teacher::whereNip($nip)->first();
        $teacher->delete();

        return response()->json($teacher);
    }

    public function searchTeacherByName(Request $request)
    {
        $search = $request->search;

        $teachers = Teacher::where('name', 'LIKE', '%' . $search . '%')
            ->get();

        return response()->json($teachers);
    }

    public function getDetailTeacher($nip)
    {
        $teacher = Teacher::whereNip($nip)->first();

        return response()->json($teacher);
    }
}
