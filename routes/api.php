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
