<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentClass;
use Exception;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function subscribeClass(Request $request)
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;

            $classId = (int) $request->class_id;

            $class = ClassModel::find($classId);

            if ($class->remain_slot === 0) {
                return response()->json([
                    "message" => "Lớp học đã kín. Không thể đăng ký"
                ], 400);
            }

            $subject_id = $class->subject->id;
            $duplicate = StudentClass::join("classes", "classes.id", "student_classes.class_id")->where("classes.subject_id", $subject_id)
                ->where("student_classes.student_id", $studentId)->first();
            if ($duplicate) {
                return response()->json([
                    "message" => "Đã đăng ký môn học này rồi"
                ], 400);
            }

            if (is_null($class)) {
                return response()->json([
                    "message" => "Không tìm thấy lớp học"
                ], 400);
            }

            $studentClass = StudentClass::create(
                [
                    "student_id" => $studentId,
                    "class_id" => $classId
                ]
            );

            return response()->json([
                "id" => $studentClass->id,
                "student_id" => $studentId,
                "class_id" => $classId,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    public function unsubscribeClass(Request $request)
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;

            $classId = (int) $request->class_id;

            $studentClass = StudentClass::where("class_id", $classId)
                ->where("student_id", $studentId)->first();

            if (is_null($studentClass)) {
                return response()->json(["message" => "Not found class"], 404);
            }

            $studentClass->delete();
            return response()->json([], 202);
        } catch (Exception $e) {
            return response()->json(
                [
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    public function listSubscribedClasses()
    {
        try {

            $classes = (new ClassModel())->getSubscribedClasses();

            return response()->json($classes, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    public function listSubscribableClasses(Request $request)
    {
        try {
            $subjectId = $request->subject_id;

            $classes = ClassModel::where("subject_id", $subjectId)
                ->where("status", ClassModel::STATUS_SCRIBALE)
                ->get();
            return response()->json($classes, 200);
        } catch (Exception $e) {
            return response()->json(
                [
                    "messsage" => $e->getMessage()
                ],
                500
            );
        }
    }

    public function listClassMates(Request $request)
    {
        try {
            $loginedStudentId = (new Helper)->getLoginedStudent()->id;
            $classId = $request->class_id;

            $studentClass = StudentClass::where("class_id", $classId)->where("student_id", $loginedStudentId)->first();

            if (is_null($studentClass)) {
                return response()->json([
                    "message" => "Bạn không nằm trong lớp này !!!"
                ], 403);
            }

            $classmates = (new Student())->getClassMates($classId);

            return response()->json($classmates, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }
}
