<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ListStudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'name');
        $orderDirection = $request->query('sort_order', 'desc');

        $students = Student::where('nis', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%');

        $students = $students->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListStudentResource::collection($students);
    }

    public function show($nis)
    {
        $student = Student::with(['class'])->whereNis($nis)->first();

        return response()->json($student);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string',
            'nisn' => 'required|string',
            'name' => 'required|string|max:255',
            'class' => 'required',
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

        $student = new Student();
        $student->class_id = $request->class[0]['id'];
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->name = $request->name;
        $student->phone_number = $request->phone_number;
        $student->place_of_birth = $request->place_of_birth;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->blood_type = $request->blood_type;
        $student->email = $request->email;
        $student->save();

        return response()->json($student);
    }

    public function update($nis, Request $request)
    {
        $student = Student::whereNis($nis)->first();

        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'nisn' => 'required|string',
            'name' => 'required|string|max:255',
            'class' => 'required',
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

        $student->class_id = $request->class[0]['id'];
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->name = $request->name;
        $student->phone_number = $request->phone_number;
        $student->place_of_birth = $request->place_of_birth;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->blood_type = $request->blood_type;
        $student->email = $request->email;
        $student->save();

        return response()->json($student);
    }

    public function delete($nis)
    {
        $student = Student::whereNis($nis)->first();
        $student->delete();

        return response()->json($student);
    }

    public function getStudentByClass($classId)
    {
        $student = Student::whereClassId($classId)->get();

        return response()->json($student);
    }
}
