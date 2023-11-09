<?php

use App\Helpers\Helper;
use App\Http\Controllers\Admin\AdminAuthController;
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
use App\Http\Controllers\Admin\ClassController as AdminClassController;
use App\Http\Controllers\Admin\IssueController as AdminIssueController;
// use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\ScoreController;
use App\Http\Middleware\AuthAdminMiddleware;

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
Route::post("/reset-password", [AuthController::class, "resetPassword"]);

Route::middleware(AuthStudentMiddleware::class)->group(function () {
    Route::post("/subscribe-class", [ClassController::class, "subscribeClass"]);
    Route::delete("/usubscribe-class", [ClassController::class, "unsubscribeClass"]);
    Route::get("list-subscribed-classes", [ClassController::class, "listSubscribedClasses"]);
    Route::get("classmates/{class_id}", [ClassController::class, "listClassMates"]);
    Route::get("list-subscribable-classes", [ClassController::class, "listSubscribableClasses"]);

    Route::get("list-subscribable-subjects", [SubjectController::class, "listSubscribaleSubjects"]);

    Route::get("list-exams", [ExamController::class, "listExams"]);

    Route::get("list-scores", [ScoreController::class, "listScores"]);
    Route::get("get-detail-score/{score_id}", [ScoreController::class, "getDetailScore"]);

    Route::get("get-profile", [StudentController::class, "getProfile"]);
    Route::put("update-profile", [StudentController::class, "updateProfile"]);
    Route::post("upload-avatar", [StudentController::class, "uploadAvatar"]);
    Route::put("change-password", [StudentController::class, "changePassword"]);

    Route::post("add-student", [StudentController::class, "addStudent"]);

    Route::post("send-issue", [IssueController::class, "sendIssue"]);
    Route::get("list-issues", [IssueController::class, "listIssues"]);
});

Route::prefix("/admin")->group(function () {
    Route::post("/login", [AdminAuthController::class, "login"]);

    Route::middleware(AuthAdminMiddleware::class)->group(function () {

        Route::post("/create-students", [AdminStudentController::class, "create"]);
        Route::get("/list-students", [AdminStudentController::class, "getAll"]);
        Route::get("/get-student/{student_id}", [AdminStudentController::class, "getDetail"]);
        Route::put("/update-student/{student_id}", [AdminStudentController::class, "update"]);
        Route::delete("/delete-student/{student_id}", [AdminStudentController::class, "destroy"]);


        Route::post("/create-teachers", [TeacherController::class, "create"]);
        Route::get("/list-teachers", [TeacherController::class, "getAll"]);
        Route::get("/get-teacher/{teacher_id}", [TeacherController::class, "getDetail"]);
        Route::put("/update-teacher/{teacher_id}", [TeacherController::class, "update"]);
        Route::post("/upload-teacher-avatar/{teacher_id}", [TeacherController::class, "uploadAvatar"]);
        Route::delete("/delete-teacher/{teacher_id}", [TeacherController::class, "delete"]);

        Route::post("/create-subjects", [AdminSubjectController::class, "create"]);
        Route::get("/list-subjects", [AdminSubjectController::class, "getAll"]);
        Route::get("/get-subject/{subject_id}", [AdminSubjectController::class, "getDetail"]);
        Route::put("/update-subject/{subject_id}", [AdminSubjectController::class, "update"]);
        Route::delete("/delete-subject/{subject_id}", [AdminSubjectController::class, "destroy"]);

        Route::post("/create-major", [MajorController::class, "create"]);
        Route::get("/list-majors", [MajorController::class, "getAll"]);
        Route::get("/get-major/{major_id}", [MajorController::class, "getDetail"]);
        Route::put("/update-major/{major_id}", [MajorController::class, "update"]);
        Route::delete("/delete-major/{major_id}", [MajorController::class, "destroy"]);

        Route::post("/create-major", [MajorController::class, "create"]);

        Route::post("/create-class", [AdminClassController::class, "create"]);
        Route::get("/list-classes/{subject_id}", [AdminClassController::class, "getBySubject"]);
        Route::get("/list-class-student/{class_id}", [AdminClassController::class, "getBySubject"]);
        Route::put("/update-class/{class_id}", [AdminClassController::class, "update"]);
        Route::delete("/delete-class/{class_id}", [AdminClassController::class, "destroy"]);

        Route::get("/list-issues", [AdminIssueController::class, "listIssues"]);
        Route::get("/get-issue/{issue_id}", [AdminIssueController::class, "listIssues"]);
        Route::put("/update-issue/{issue_id}", [AdminIssueController::class, "updateIssue"]);
    });
});
