<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Teachers extends JsonResource
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
            'teacher_code'=>$this->teacher_code,
            'academic_level'=>$this->academic_level,
            'position' =>$this->position,
            'department' =>$this->crdepartmentedit,
            'resume' =>$this->resume,
            'major_id' =>$this->major_id,
           
            // 'created_at' => $this?->created_at->format('d/m/Y'),
            // 'updated_at' => $this?->updated_at->format('d/m/Y'),
            ];
    }
}
