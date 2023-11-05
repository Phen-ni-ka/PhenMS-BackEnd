<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function getAll()
    {
       try {
            $teacher = Teacher::all();
            return response()->json($teacher, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    public function create(Request $request)
    {
        try {
            
            $email = $request->email;
            $fullname = $request->fullname;
            $teacher_code = $request->teacher_code;
            $academic_level = $request->academic_level;
            $position= $request->position;
            $department = $request->department;
            $resume = $request->resume;
            $major_id = $request->major_id;


            $teacher = Teacher::create(
                [        
                    
                    'email' => $email, 
                    'fullname' => $fullname,
                    'teacher_code' => $teacher_code, 
                    'academic_level' => $academic_level,
                    'position' => $position,
                    'department' => $department, 
                    'resume' => $resume,
                    'major_id' => $major_id, 
                   
                ]
            );
            return response()->json([$teacher], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function getDetail(Teacher $teacher ,$teacherId)
    {
        try {
            $teacher = Teacher::find($teacherId);
            return response()->json($teacher, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Teacher $teacher ,$teacherId, Request $request)
    {
        try {
            $teacher = Teacher::find($teacherId);
            $teacher->update($request->all());
            return response()->json([$teacher], 200);
        } catch(Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher ,$teacherId)
    {   
    try {
        $teacher = Teacher::find($teacherId);
        $teacher->delete();
        return response()->json("Xóa thành công");

    } catch (Exception $e) {
        return response()->json([
            "message" => $e->getMessage()
         ], 500);
    }
    }
}