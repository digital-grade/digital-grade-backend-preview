<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SchoolYearController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
// Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
// Route::put('/reset-password', [UserController::class, 'updatePasswordUsingToken']);

/** For get user info from token */
Route::get('token/user/detail', [UserController::class, 'getUserInfoFromToken']);
/** End for get user info from token */

/** For Teacher */
Route::group(['prefix' => 'teacher'], function () {
    Route::get('/', [TeacherController::class, 'index']);
    Route::post('/', [TeacherController::class, 'create']);
    Route::get('{nip}/show', [TeacherController::class, 'show']);
    Route::put('{nip}/update', [TeacherController::class, 'update']);
    Route::delete('{nip}/delete', [TeacherController::class, 'delete']);
    Route::get('search-teacher-by-name', [TeacherController::class, 'searchTeacherByName']);
});
/** End For Teacher */

/** For Student */
Route::group(['prefix' => 'student'], function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/', [StudentController::class, 'create']);
    Route::get('{nis}/show', [StudentController::class, 'show']);
    Route::put('{nis}/update', [StudentController::class, 'update']);
    Route::delete('{nis}/delete', [StudentController::class, 'delete']);
});
/** End For Student */

/** For Course */
Route::group(['prefix' => 'course'], function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'create']);
    Route::get('{id}/show', [CourseController::class, 'show']);
    Route::put('{id}/update', [CourseController::class, 'update']);
    Route::delete('{id}/delete', [CourseController::class, 'delete']);
    Route::get('search-course-by-name', [CourseController::class, 'searchCourseByName']);
});
/** End For Course */

/** For Class */
Route::group(['prefix' => 'class'], function () {
    Route::get('/', [ClassController::class, 'index']);
    Route::post('/', [ClassController::class, 'create']);
    Route::get('{id}/show', [ClassController::class, 'show']);
    Route::put('{id}/update', [ClassController::class, 'update']);
    Route::delete('{id}/delete', [ClassController::class, 'delete']);
    Route::get('search-class-by-name', [ClassController::class, 'searchClassByName']);
});
/** End For Class */

/** For Schedule */
Route::group(['prefix' => 'schedule'], function () {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::post('/', [ScheduleController::class, 'create']);
    Route::get('{id}/show', [ScheduleController::class, 'show']);
    Route::put('{id}/update', [ScheduleController::class, 'update']);
    Route::delete('{id}/delete', [ScheduleController::class, 'delete']);
    Route::get('{nip}/get-schedule-by-nip', [ScheduleController::class, 'getScheduleByNip']);
});
/** End For Schedule */

/** For School Year */
Route::group(['prefix' => 'school-year'], function () {
    Route::get('/', [SchoolYearController::class, 'index']);
    Route::post('/', [SchoolYearController::class, 'create']);
    Route::get('{id}/show', [SchoolYearController::class, 'show']);
    Route::put('{id}/update', [SchoolYearController::class, 'update']);
    Route::delete('{id}/delete', [SchoolYearController::class, 'delete']);
    Route::get('get-school-year', [SchoolYearController::class, 'getSchoolYear']);
});
/** End For School Year */

/** For School Year */
Route::group(['prefix' => 'grade'], function () {
    Route::get('{scheduleId}/get-data', [GradeController::class, 'getGradeByClass']);
    Route::post('save-data', [GradeController::class, 'saveGradeByClass']);
});
/** End For School Year */