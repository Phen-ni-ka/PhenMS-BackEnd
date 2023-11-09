<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $limit = isset($limit) ? $limit : 10;
            $page = isset($page) ? $page : 1;
            $data = Teacher::paginate($limit, ['*'], 'page', $page);

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
                        "academic_level" => $row[2],
                        "major_id" => $row[3],
                        "department" => $row[4],
                        "created_at" => $now,
                        "updated_at" => $now,
                    ];

                    $createdTeacher = Teacher::create($dataRow);
                    $createdTeacher->update([
                        "teacher_code" => Carbon::now()->year * 10000 + $createdTeacher->id
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

    public function getDetail(Request $request)
    {
        try {
            $teacherId = $request->teacher_id;
            $teacher = Teacher::find($teacherId);
            return response()->json($teacher, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function uploadAvatar(Request $request)
    {
        try {
            $teacherId = $request->teacher_id;
            $file = request()->file()["avatar"];

            $fileData = file_get_contents($file);

            $response = Http::attach("image", base64_encode($fileData))->post("https://api.imgbb.com/1/upload?key=" . "6bb3b4cbd591599c10924e97efc6108c");
            if ($response->status() != 200) {
                return response()->json([
                    "messsage" => "Tải ảnh lên thất bại !!!"
                ], 400);
            }
            $result = $response->json()["data"];

            $teacher = Teacher::find($teacherId);
            $teacher->avatar_url = $result["url"];
            $teacher->save();

            return response()->json([], 201);
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $teacherId = $request->teacher_id;
            $teacher = Teacher::find($teacherId);
            $teacher->update($request->all());
            return response()->json($teacher, 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $teacherId = $request->teacher_id;
            $teacher = Teacher::find($teacherId);
            $teacher->delete();
            return response()->json([], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
