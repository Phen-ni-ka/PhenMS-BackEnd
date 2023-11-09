<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Score;
use Exception;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function listScores()
    {
        try {
            $loginedStudentId = (new Helper)->getLoginedStudent()->id;

            $scores = Score::where("student_id", $loginedStudentId)->orderBy("id", "desc")->get()->makeHidden(["created_at", "updated_at", "deleted_at"]);
            return response()->json($scores, 200);
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function getDetailScore(Request $request)
    {
        try {
            $scoreIDd = $request->score_id;
            $loginedStudentId = (new Helper)->getLoginedStudent()->id;

            $score = Score::find($scoreIDd);
            if ($score->student_id !== $loginedStudentId) {
                return response()->json([
                    "messsage" => "Điểm này không phải của bạn"
                ], 500);
            }
            return response()->json($score, 200);
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }
}
