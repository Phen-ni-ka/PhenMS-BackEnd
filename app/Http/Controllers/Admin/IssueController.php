<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Issue;
use Exception;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function listIssues(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $limit = isset($limit) ? $limit : 10;
            $page = isset($page) ? $page : 1;
            $data = Issue::orderBy("id", "DESC")->paginate($limit, ['*'], 'page', $page);

            $items = $data->items();
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i] === Issue::STATUS_SENT) {
                    $items[$i]->update([
                        "status_id" => Issue::STATUS_PROCESSING
                    ]);
                }
            }
            $result = (new Helper)->formatPaginate($data);
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function updateIssue(Request $request)
    {
        try {
            $statusId = $request->status_id;
            $issueId = $request->issue_id;

            $issue = Issue::find($issueId);
            $issue->update([
                "status_id" => $statusId
            ]);
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getIssue(Request $request)
    {
        try {
            $issueId = $request->issue_id;

            $issue = Issue::find($issueId);

            return response()->json($issueId, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
