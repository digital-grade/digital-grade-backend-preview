<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolYear\ListSchoolYearResource;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Validator;

class SchoolYearController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'name');
        $orderDirection = $request->query('sort_order', 'desc');

        $schoolYears = SchoolYear::where('start_year', 'LIKE', '%' . $search . '%')
            ->orWhere('end_year', 'LIKE', '%' . $search . '%');

        $schoolYears = $schoolYears->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListSchoolYearResource::collection($schoolYears);
    }

    public function show($id)
    {
        $schoolYear = SchoolYear::find($id);

        return response()->json($schoolYear);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_year' => 'required',
            'end_year' => 'required',
            'semester' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $schoolYear = new SchoolYear();
        $schoolYear->start_year = $request->start_year;
        $schoolYear->end_year = $request->end_year;
        $schoolYear->semester = $request->semester;
        $schoolYear->save();

        return response()->json($schoolYear);
    }

    public function update($nis, Request $request)
    {
        $schoolYear = SchoolYear::whereNis($nis)->first();

        $validator = Validator::make($request->all(), [
            'start_year' => 'required',
            'end_year' => 'required',
            'semester' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $schoolYear->start_year = $request->start_year;
        $schoolYear->end_year = $request->end_year;
        $schoolYear->semester = $request->semester;
        $schoolYear->save();

        return response()->json($schoolYear);
    }

    public function delete($nis)
    {
        $schoolYear = SchoolYear::whereNis($nis)->first();
        $schoolYear->delete();

        return response()->json($schoolYear);
    }

    public function getSchoolYear()
    {
        $schoolYear = SchoolYear::orderBy('id', 'DESC')->get()->take(2);

        return response()->json($schoolYear);
    }
}
