<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Exception;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function getAll()
    {
       try {
            $major = Major::all();
            return response()->json($major, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    public function create(Request $request)
    {
        try {
            $majorId = $request->major_id;
            $name = $request->name;
            $major_code = $request->major_code;
            $major = Major::create(
                [        
                    "majorId" => $majorId,
                    'name' => $name, 
                    'major_code' => $major_code,
                ]
            );
            return response()->json([$major], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function getDetail(Major $major ,$majorId)
    {
        try {
            $major = Major::find($majorId);
            return response()->json($major, 200);

       } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
             ], 500);
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Major $major ,$majorId, Request $request)
    {
        try {
            $major = Major::find($majorId);
            $major->update($request->all());
            return response()->json([$major], 200);
        } catch(Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major ,$majorId)
    {   
    try {
        $major = Major::find($majorId);
        $major->delete();
        return response()->json("Xóa thành công");

    } catch (Exception $e) {
        return response()->json([
            "message" => $e->getMessage()
         ], 500);
    }
    }
}