<?php

namespace App\Http\Controllers;

use App\Http\Resources\Students;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( )
    {
        $students = Student::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách thông tin sinh viên",
            'data'=> Students::collection($students)
  ];
       
         return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student, int $id)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $id)
    {
        //return response()->json($request->all());
        $input = $request->all(); 
        $validator = \Validator::make($input, [
        'email' => 'required', 
        'fullname' => 'required',
        'student_code' => 'required', 
        'gender' => 'required',
        'school_year' => 'required',
        'identity_code' => 'required', 
        'date_of_birth' => 'required',
        'phone_number' => 'required', 
        'birthplace' => 'required',
        'home_town' => 'required', 
        'ward' => 'required',
        'district' => 'required', 
        'province' => 'required',
        'address' => 'required', 
        'status_id' => 'required',
        'major_id' => 'required'
    ]);
   
        if($validator->fails() ){
             $arr = [
                  'success' => false,
                  'message' => 'Lỗi kiểm tra dữ liệu',
                  'data' => $validator->errors()
    ];
         return response()->json($arr, 200);
 }      
   
    $student = Student::create($input);
    $arr = [
        'status' => true,
        'message'=>"Thông tin sinh viên đã lưu thành công",
        'data'=> new Students($student)
];
     return response()->json($arr, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(int $id )
    {
//         $students = Student::find($id);
//         $arr = [
//             'status' => true,
//             'message' => "Chi tiết thông tin sinh viên",
//             'data'=> Students::collection($students)
//   ];
//          return response()->json($arr, 200);
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
    public function update(Request $request, Student $student, int $id)
    {
    $student = Student::find($id);
    $input = $request->all();
    $validator = \Validator::make($input, [
        'email' => 'required', 
        'fullname' => 'required',
        'student_code' => 'required', 
        'gender' => 'required',
        'school_year' => 'required',
        'identity_code' => 'required', 
        'date_of_birth' => 'required',
        'phone_number' => 'required', 
        'birthplace' => 'required',
        'home_town' => 'required', 
        'ward' => 'required',
        'district' => 'required', 
        'province' => 'required',
        'address' => 'required', 
        'status_id' => 'required',
        'major_id' => 'required'
    ]);
    if($validator->fails() ){
     $arr = [
       'success' => false,
       'message' => 'Lỗi kiểm tra dữ liệu',
       'data' => $validator->errors()
];  
     return response()->json($arr, 200);
}
    $student->email = $input['email'];
    $student->fullname = $input['fullname'];
    $student->student_code = $input['student_code'];
    $student->gender = $input['gender'];
    $student->school_year = $input['school_year'];
    $student->identity_code = $input['identity_code'];
    $student->date_of_birth = $input['date_of_birth'];
    $student->phone_number = $input['phone_number'];
    $student->birthplace = $input['birthplace'];
    $student->home_town = $input['home_town'];
    $student->ward = $input['ward'];
    $student->district = $input['district'];
    $student->province = $input['province'];
    $student->address = $input['address'];
    $student->status_id = $input['status_id'];
    $student->major_id = $input['major_id'];    
    $student->save();
    $arr = [
     'status' => true,
     'message' => 'Thông tin sinh viên cập nhật thành công',
     'data' => new Students($student)
];
    return response()->json($arr, 200);        
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student, int $id )
    {
            $student = Student::find($id);

            if (!$student) {
                return response()->json(['error' => 'Lỗi kiểm tra dữ liệu'], 404);
            }

            $student->delete();

                return response()->json(['Xóa thành công' => true], 200);
    }
}
