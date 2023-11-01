<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Students extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
        'email'=>$this->email,
        'fullname'=>$this->fullname,
        'password'=>$this->password,
        'student_code'=>$this->student_code,
        'gender'=>$this->gender,
        'school_year' =>$this->school_year,
        'identity_code'=>$this->identity_code,
        'date_of_birth'=>$this->date_of_birth,
        'phone_number'=>$this->phone_number,
        'birthplace'=>$this->birthplace,
        'home_town'=>$this->home_town,
        'ward'=>$this->ward,
        'district'=>$this->district,
        'province'=>$this->province,
        'address'=>$this->address,
        'status_id'=>$this->status_id,
        'major_id'=>$this->major_id,
        // 'created_at' => $this?->created_at->format('d/m/Y'),
        // 'updated_at' => $this?->updated_at->format('d/m/Y'),
        ];

    }
}
