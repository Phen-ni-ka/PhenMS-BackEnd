<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\StudentClass;
use Exception;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create(Request $request)
    {
        try {
            ClassModel::create($request->all());

            return response()->json([], 201);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getBySubject(Request $request)
    {
        try {
            $subjectId = $request->subject_id;

            $result = ClassModel::where("subject_id", $subjectId)->get();
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function listClassStudent(Request $request)
    {
        try {
            $classId = $request->class_id;

            $result = StudentClass::where("class_id", $classId)->get();
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $classId = $request->class_id;

            $inputData = $request->except(["subject_id", "class_id"]);
            $class = ClassModel::find($classId);

            $class->update($inputData);
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $classId = $request->class_id;
            $class = ClassModel::find($classId);
            $class->delete();
            return response()->json("Xóa thành công");
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
