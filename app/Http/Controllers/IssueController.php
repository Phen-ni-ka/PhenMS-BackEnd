<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Issue;
use Exception;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function sendIssue(Request $request)
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;
            $title = $request->title;
            $content = $request->content;

            Issue::created(
                [
                    "title" => $title,
                    "content" => $content,
                    "studentId" => $studentId
                ]
            );

            return response()->json([], 201);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function listIssues()
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;

            $issues = Issue::where("student_id", $studentId)->get();

            return response()->json([$issues], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
