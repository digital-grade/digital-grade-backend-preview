<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassesStudent;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function getGradeByClass(Request $request, $scheduleId)
    {
        $search = $request->search;

        $grades = Grade::whereScheduleId($scheduleId)->get();

        $schedule = Schedule::find($scheduleId);

        $classes = Classes::with(['student'])
            ->whereId($schedule->class_id)
            ->first();

        $gradeData = [];
        if (count($grades) == 0) {
            foreach ($classes->student as $student) {
                $gradeData[] = [
                    'nis' => $student->nis,
                    'class_id' => $classes->id,
                    'name' => $student->name,
                    'grade' => 0,
                ];
            }
        } else {
            foreach ($grades as $grade) {
                $classesStudent = ClassesStudent::find($grade->classes_student_id);

                $student = Student::find($classesStudent->student_nis);
                
                $gradeData[] = [
                    'nis' => $student->nis,
                    'class_id' => $classes->id,
                    'name' => $student->name,
                    'grade' => $grade->grade,
                ];
            }
        }

        return response()->json($gradeData);
    }

    public function saveGradeByClass(Request $request)
    {
        $grades = $request->grades;

        foreach ($grades as $grade) {
            $classesStudent = ClassesStudent::where('classes_id', $grade['classId'])
                ->where('student_nis', $grade['studentNis'])
                ->first();

            $gradeData = Grade::where('classes_student_id', $classesStudent->id)
                ->where('schedule_id', $request->id)
                ->first();

            if (is_null($gradeData)) {
                $gradeData = Grade::create([
                    'classes_student_id' => $classesStudent->id,
                    'schedule_id' => $request->id,
    
                    'grade' => $grade['grade'],
                ]);
            } else {
                $gradeData->update([
                    'grade' => $grade['grade']
                ]);
            }
        }
    }
}
