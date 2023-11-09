<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $limit = isset($limit) ? $limit : 10;
            $page = isset($page) ? $page : 1;
            $data = Student::paginate($limit, ['*'], 'page', $page);

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
                        "email" => $row[0],
                        "fullname" => $row[1],
                        "gender" => $row[2],
                        "major_id" => $row[3],
                        "school_year" => $row[4],
                        "password" => "password",
                        "created_at" => $now,
                        "updated_at" => $now,
                    ];

                    $createdStudent = Student::create($dataRow);
                    $createdStudent->update([
                        "student_code" => Carbon::now()->year * 10000 + $createdStudent->id
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
    public function getDetail(Student $student, $studentId)
    {
        try {
            $student = Student::find($studentId);
            return response()->json($student, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Student $student, $studentId, Request $request)
    {
        try {
            $student = Student::find($studentId);
            $student->update($request->all());
            return response()->json([$student], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $studentId = $request->student_id;
            $student = Student::find($studentId);
            $student->delete();
            return response()->json("Xóa thành công");
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
