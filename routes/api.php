<?php

use App\Helpers\Helper;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SubjectController;
use App\Http\Middleware\AuthStudentMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;


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
    Route::post("/usubscribe-class", [ClassController::class, "unsubscribeClass"]);
    Route::get("list-subscribed-classes", [ClassController::class, "listSubscribedClasses"]);
    Route::get("classmates/{class_id}", [ClassController::class, "listClassMates"]);
    Route::get("list-subscribable-classes", [ClassController::class, "listSubscribableClasses"]);

    Route::get("list-subscribable-subjects", [SubjectController::class, "listSubscribaleSubjects"]);

    Route::get("list-exams", [ExamController::class, "listExams"]);
});



Route::resource('list-student',StudentController::class);
Route::resource('list-teacher',TeacherController::class);

Route::resource('list-subject',SubjectController::class);
Route::resource('list-major',MajorController::class);

