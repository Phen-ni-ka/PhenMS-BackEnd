<?php

namespace App\Http\Controllers;

use App\Http\Resources\Majors;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MajorController extends Controller
{
    public function index()
    {
        $major = Major::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách thông tin ngành học",
            'data'=> Majors::collection($major)
  ];
         return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return response()->json($request->all());
        $input = $request->all(); 
        $validator = \Validator::make($input, [
        'name' => 'required', 
        'major_code' => 'required'      
    ]);
        if($validator->fails()){
             $arr = [
                  'success' => false,
                  'message' => 'Lỗi kiểm tra dữ liệu',
                  'data' => $validator->errors()
    ];
         return response()->json($arr, 200);
 }
    $major = Major::create($input);
    $arr = [
        'status' => true,
        'message'=>"Thông tin ngành học đã lưu thành công",
        'data'=> new Majors($major)
];
     return response()->json($arr, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major, int $id)
    {
    $major = Major::find($id);
    $input = $request->all();
    $validator = \Validator::make($input, [
        'name' => 'required', 
        'major_code' => 'required'  
    ]);
    if($validator->fails()){
     $arr = [
       'success' => false,
       'message' => 'Lỗi kiểm tra dữ liệu',
       'data' => $validator->errors()
];
     return response()->json($arr, 200);
}
    $major->name = $input['name'];
    $major->major_code = $input['major_code'];
    
    $major->update();
    $arr = [
     'status' => true,
     'message' => 'Thông tin ngành học cập nhật thành công',
     'data' => new Majors($major)
];
    return response()->json($arr, 200);        
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major, int $id )
    {
            $major = Major::find($id);

            if (!$major) {
                return response()->json(['error' => 'Lỗi kiểm tra dữ liệu'], 404);
            }

            $major->delete();

                return response()->json(['Xóa thành công' => true], 200);
    }
}
