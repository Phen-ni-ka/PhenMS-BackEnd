<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\ReportMail;
use App\Models\Issue;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getProfile()
    {
        try {
            $logiendStudent = (new Helper)->getLoginedStudent();

            return response()->json($logiendStudent);
        } catch (Exception $e) {
            return response()->json(
                [
                    "message" => $e->getMessage()
                ],
                500
            );
        }
    }

    public function updateProfile()
    {
        try {
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function uploadAvatar()
    {
        try {
            $logiendStudent = (new Helper)->getLoginedStudent();

            $file = request()->file()["avatar"];

            $fileData = file_get_contents($file);

            $response = Http::attach("image", base64_encode($fileData))->post("https://api.imgbb.com/1/upload?key=" . "6bb3b4cbd591599c10924e97efc6108c");
            if ($response->status() != 200) {
                return response()->json([
                    "messsage" => "Tải ảnh lên thất bại !!!"
                ], 400);
            }
            $result = $response->json()["data"];

            $student = Student::find($logiendStudent->id);
            $student->avatar_url = $result["url"];
            $student->save();

            return response()->json([], 201);
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $currentPassword = $request->current_password;
            $newPassword = $request->new_password;
            $confirmPassword = $request->confirm_password;

            $loginedStudent = (new Helper)->getLoginedStudent();

            if ($loginedStudent->password !== $currentPassword) {
                return response()->json([
                    "messsage" => "Không đúng mật khẩu"
                ], 500);
            }

            if ($newPassword !== $confirmPassword) {
                return response()->json([
                    "messsage" => "Nhập giống mật khẩu mới"
                ], 500);
            }

            $student = Student::find($loginedStudent->id);

            $student->password = $newPassword;

            return [];
        } catch (Exception $e) {
            return response()->json([
                "messsage" => $e->getMessage()
            ], 500);
        }
    }

    public function addStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return back()->withErrors($validator);
        }

        $file = $request->file('csv_file');

        // Read the CSV file using fgetcsv without storing it
        $csvFile = fopen($file->path(), 'r');

        // Process the CSV data
        while (($data = fgetcsv($csvFile)) !== false) {
            dump($data);
        }
        dd("Duy");

        fclose($csvFile);
    }
}
