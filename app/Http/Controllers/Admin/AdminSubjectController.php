<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    public function getAll()
    {
       try {
            $subject = Subject::all();
            return response()->json($subject, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    public function create(Request $request)
    {
        try {
            $subjectId = $request->subject_id;
            $name = $request->name;
            $total_period_theory = $request->total_period_theory;
            $total_period_practice = $request->total_period_practice;
            $semester= $request->semester;
            $school_year = $request->school_year;
            $credit = $request->credit;


            $subject = Subject::create(
                [        
                    "subject_id" => $subjectId,
                    'name' => $name,
                    'total_period_theory' => $total_period_theory, 
                    'total_period_practice' => $total_period_practice,
                    'semester' => $semester,
                    'school_year' => $school_year, 
                    'credit' => $credit,
                   
                ]
            );
            return response()->json([$subject], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function getDetail(Subject $subject ,$subjectId)
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
    public function update(Subject $subject ,$subjectId, Request $request)
    {
        try {
            $subject = Subject::find($subjectId);
            $subject->update($request->all());
            return response()->json([$subject], 200);
        } catch(Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject ,$subjectId)
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