<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\MajorSubject;
use App\Models\Subject;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSubjectController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $school_year = $request->school_year;
            $limit = $request->limit;
            $page = $request->page;
            $limit = isset($limit) ? $limit : 10;
            $page = isset($page) ? $page : 1;
            $data = Subject::paginate($limit, ['*'], 'page', $page);
            if (isset($school_year)) {
                $data = Subject::where("school_year", $school_year)->paginate($limit, ['*'], 'page', $page);
            }

            $result = (new Helper)->formatPaginate($data);
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $validator = Validator::make($request->all(), [
                'csv_file' => 'required|mimes:csv,txt'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $file = $request->file('csv_file');

            $csvFile = fopen($file->path(), 'r');
            $header = fgetcsv($csvFile);
            $index = 0;
            $totalSuccess = 0;
            $totalErr = 0;
            while (($row = fgetcsv($csvFile)) !== false) {
                try {
                    $index++;
                    $dataRow = [
                        "name" => $row[0],
                        "total_period_theory" => $row[1],
                        "total_period_practice" => $row[2],
                        "semester" => $row[3],
                        "school_year" => $row[4],
                        "credit" => $row[6],
                        "created_at" => $now,
                        "updated_at" => $now,
                    ];

                    $createdSubject = Subject::create($dataRow);
                    $major = Major::find($row[6]);
                    if (is_null($major)) {
                        $totalErr++;
                        continue;
                    }
                    MajorSubject::create([
                        "major_id" => $row[6],
                        "subject_id" => $createdSubject->id
                    ]);
                    $totalSuccess++;
                } catch (Exception $e) {
                    $totalErr++;
                }
            }

            fclose($csvFile);

            return response()->json([
                "total_success" => $totalSuccess,
                "total_err" => $totalErr
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getDetail(Subject $subject, $subjectId)
    {
        try {
            $subject = Subject::find($subjectId);
            return response()->json($subject, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Subject $subject, $subjectId, Request $request)
    {
        try {
            $subject = Subject::find($subjectId);
            $subject->update($request->all());
            return response()->json([$subject], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, $subjectId)
    {
        try {
            $subject = Subject::find($subjectId);
            $subject->delete();
            return response()->json("Xóa thành công");
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
