<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Exam;
use Exception;

class ExamController extends Controller
{
    public function listExams()
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;

            $exams = Exam::where("student_id", $studentId)->get();

            return response()->json([$exams], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
