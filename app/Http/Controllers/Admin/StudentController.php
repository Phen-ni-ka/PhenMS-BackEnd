<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAll()
    {
       try {
            $student = Student::all();
            return response()->json($student, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    public function create(Request $request)
    {
        try {
            $studentId = $request->student_id;
            $email = $request->email;
            $password = $request->password;
            $fullname = $request->fullname;
            $student_code = $request->student_code;
            $gender = $request->gender;
            $school_year= $request->school_year;
            $identity_code = $request->identity_code;
            $date_of_birth = $request->date_of_birth;
            $phone_number = $request->phone_number;
            $birthplace = $request->birthplace;
            $home_town = $request->home_town;
            $ward = $request->ward;
            $district = $request->district;
            $province = $request->province;
            $address = $request->address;
            $status_id = $request->status_id;
            $major_id = $request->major_id;

            $student = Student::create(
                [        
                    "studentId" => $studentId,
                    'email' => $email, 
                    'password' => $password,
                    'fullname' => $fullname,
                    'student_code' => $student_code, 
                    'gender' => $gender,
                    'school_year' => $school_year,
                    'identity_code' => $identity_code, 
                    'date_of_birth' => $date_of_birth,
                    'phone_number' => $phone_number, 
                    'birthplace' => $birthplace,
                    'home_town' => $home_town, 
                    'ward' => $ward,
                    'district' => $district, 
                    'province' => $province,
                    'address' => $address, 
                    'status_id' => $status_id,
                    'major_id' => $major_id,
                ]
            );
            return response()->json([$student], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function getDetail(Student $student ,$studentId)
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
    public function update(Student $student ,$studentId, Request $request)
    {
        try {
            $student = Student::find($studentId);
            $student->update($request->all());
            return response()->json([$student], 200);
        } catch(Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student ,$studentId)
    {   
    try {
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