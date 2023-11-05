<?php

use App\Helpers\Helper;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Middleware\AuthStudentMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\MajorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/login", [AuthController::class, "login"]);
Route::post("/login-with-google", [AuthController::class, "loginGoogle"]);
Route::post("/forget-password", [AuthController::class, "forgetPassword"]);
Route::get("/reset-password", [AuthController::class, "redirectToReset"])->name("password.reset");

Route::middleware(AuthStudentMiddleware::class)->group(function () {
    Route::post("/subscribe-class", [ClassController::class, "subscribeClass"]);
    Route::delete("/usubscribe-class", [ClassController::class, "unsubscribeClass"]);
    Route::get("list-subscribed-classes", [ClassController::class, "listSubscribedClasses"]);
    Route::get("classmates/{class_id}", [ClassController::class, "listClassMates"]);
    Route::get("list-subscribable-classes", [ClassController::class, "listSubscribableClasses"]);

    Route::get("list-subscribable-subjects", [SubjectController::class, "listSubscribaleSubjects"]);

    Route::get("list-exams", [ExamController::class, "listExams"]);

    Route::get("get-profile", [StudentController::class, "getProfile"]);
    Route::put("update-profile", [StudentController::class, "updateProfile"]);
    Route::post("upload-avatar", [StudentController::class, "uploadAvatar"]);
    Route::put("change-password", [StudentController::class, "changePassword"]);

    Route::post("add-student", [StudentController::class, "addStudent"]);

    Route::post("send-issue", [IssueController::class, "sendIssue"]);
    Route::get("list-issues", [IssueController::class, "listIssues"]);
});


Route::controller(StudentController::class)->group(function () {
        Route::post("/create-student", [StudentController::class,"create"]);
        Route::get("/list-student", [StudentController::class,"getAll"]);
        Route::get("/list-student/{student_id}", [StudentController::class,"getDetail"]);
        Route::put("/update-student/{student_id}", [StudentController::class,"update"]);
        Route::delete("/delete-student/{student_id}", [StudentController::class,"destroy"]);
});

Route::controller(TeacherController::class)->group(function () {
    Route::post("/create-teacher", [TeacherController::class,"create"]);
    Route::get("/list-teacher", [TeacherController::class,"getAll"]);
    Route::get("/list-teacher/{teacher_id}", [TeacherController::class,"getDetail"]);
    Route::put("/update-teacher/{teacher_id}", [TeacherController::class,"update"]);
    Route::delete("/delete-teacher/{teacher_id}", [TeacherController::class,"destroy"]);
});

Route::controller(AdminSubjectController::class)->group(function () {
    Route::post("/create-subject", [AdminSubjectController::class,"create"]);
    Route::get("/list-subject", [AdminSubjectController::class,"getAll"]);
    Route::get("/list-subject/{subject_id}", [AdminSubjectController::class,"getDetail"]);
    Route::put("/update-subject/{subject_id}", [AdminSubjectController::class,"update"]);
    Route::delete("/delete-subject/{subject_id}", [AdminSubjectController::class,"destroy"]);
});

Route::controller(MajorController::class)->group(function () {
    Route::get("/list-major", [MajorController::class,"getAll"]);
    Route::get("/list-major/{major_id}", [MajorController::class,"getDetail"]);
    Route::put("/update-major/{major_id}", [MajorController::class,"update"]);
    Route::delete("/delete-major/{major_id}", [MajorController::class,"destroy"]);
});

