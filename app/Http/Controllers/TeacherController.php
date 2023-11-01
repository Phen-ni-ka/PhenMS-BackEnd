<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Teachers;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
class TeacherController extends Controller
{
    public function index()
    {

        $teacher = Teacher::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách thông tin giảng viên ",
            'data'=> Teachers::collection($teacher)
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
        'email' => 'required', 
        'fullname' => 'required',
        'teacher_code' => 'required', 
        'academic_level' => 'required',
        'position' => 'required',
        'department' => 'required', 
        'resume' => 'required',
        'major_id' => 'required'
    ]);
        if($validator->fails()){
             $arr = [
                  'success' => false,
                  'message' => 'Lỗi kiểm tra dữ liệu',
                  'data' => $validator->errors()
    ];
         return response()->json($arr, 200);
 }
    $teacher = Teacher::create($input);
    $arr = [
        'status' => true,
        'message'=>"Thông tin giảng viên đã lưu thành công",
        'data'=> new Teachers($teacher)
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
    public function update(Request $request, Teacher $teacher, int $id)
    {
    $teacher = Teacher::find($id);
    $input = $request->all();
    $validator = \Validator::make($input, [
        'email' => 'required', 
        'fullname' => 'required',
        'teacher_code' => 'required', 
        'academic_level' => 'required',
        'position' => 'required',
        'department' => 'required', 
        'resume' => 'required',
        'major_id' => 'required'
    ]);
    if($validator->fails()){
     $arr = [
       'success' => false,
       'message' => 'Lỗi kiểm tra dữ liệu',
       'data' => $validator->errors()
];
     return response()->json($arr, 200);
}
    $teacher->email = $input['email'];
    $teacher->fullname = $input['fullname'];
    $teacher->teacher_code = $input['teacher_code'];
    $teacher->academic_level = $input['academic_level'];
    $teacher->position = $input['position'];
    $teacher->department = $input['department'];
    $teacher->resume = $input['resume'];
    $teacher->major_id = $input['major_id'];
    $teacher->save();
    $arr = [
     'status' => true,
     'message' => 'Thông tin giảng viên cập nhật thành công',
     'data' => new Teachers($teacher)
];
    return response()->json($arr, 200);        
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher, int $id )
    {
            $teacher = Teacher::find($id);

            if (!$teacher) {
                return response()->json(['error' => 'Lỗi kiểm tra dữ liệu'], 404);
            }

            $teacher->delete();

                return response()->json(['Xóa thành công' => true], 200);
    }

}
