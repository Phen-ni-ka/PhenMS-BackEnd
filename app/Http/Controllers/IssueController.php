<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\ReportMail;
use App\Models\Issue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IssueController extends Controller
{
    public function sendIssue(Request $request)
    {
        try {
            $loginedStudent = (new Helper)->getLoginedStudent();
            $data = [
                "name" => $loginedStudent->fullname,
                "email" => $loginedStudent->email,
                "student_code" => $loginedStudent->student_code,
                "school_year" => $loginedStudent->school_year,
                "title" => $request->title,
                "detail" => $request->detail
            ];
            Mail::to(env("ADMIN_EMAIL"))->send(new ReportMail($data));

            Issue::create([
                "title" => $request->title,
                "detail" => $request->detail,
                "status_id" => Issue::STATUS_SENT,
                "student_id" => $loginedStudent->id,
            ]);

            return [];
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function listIssues(Request $request)
    {
        try {
            $studentId = (new Helper)->getLoginedStudent()->id;

            $issues = Issue::where("student_id", $studentId)->get();

            return response()->json($issues, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
