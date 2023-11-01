<?php

namespace App\Http\Controllers;

use App\Http\Resources\Subjects;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách thông tin môn học",
            'data'=> Subjects::collection($subjects)
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
        'total_period_theory' => 'required',
        'total_period_practice' => 'required', 
        'semester' => 'required',
        'school_year' => 'required',
        'credit' => 'required'
    ]);
        if($validator->fails()){
             $arr = [
                  'success' => false,
                  'message' => 'Lỗi kiểm tra dữ liệu',
                  'data' => $validator->errors()
    ];
         return response()->json($arr, 200);
 }
    $subject = Subject::create($input);
    $arr = [
        'status' => true,
        'message'=>"Thông tin môn học đã lưu thành công",
        'data'=> new Subjects($subject)
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
    public function update(Request $request, Subject $subject, int $id)
    {
    $subject = Subject::find($id);

    $input = $request->all();
    $validator = \Validator::make($input, [
        'name' => 'required', 
        'total_period_theory' => 'required',
        'total_period_practice' => 'required', 
        'semester' => 'required',
        'school_year' => 'required',
        'credit' => 'required'
    ]);
    if($validator->fails()){
     $arr = [
       'success' => false,
       'message' => 'Lỗi kiểm tra dữ liệu',
       'data' => $validator->errors()
];
     return response()->json($arr, 200);
}
    $subject->name = $input['name'];
    $subject->total_period_theory = $input['total_period_theory'];
    $subject->total_period_practice = $input['total_period_practice'];
    $subject->semester = $input['semester'];
    $subject->school_year = $input['school_year'];
    
    $subject->credit = $input['credit'];
  
    $subject->save();
    $arr = [
     'status' => true,
     'message' => 'Thông tin môn học cập nhật thành công',
     'data' => new Subjects($subject)
];
    return response()->json($arr, 200);        
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, int $id )
    {
            $subject = Subject::find($id);
            if (!$subject) {
                return response()->json(['error' => 'Lỗi kiểm tra dữ liệu'], 404);
            } 
            $subject->delete();
                return response()->json(['Xóa thành công' => true], 200);
            
    }
}
