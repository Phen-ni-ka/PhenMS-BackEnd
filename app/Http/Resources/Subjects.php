<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Subjects extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) 
    {
        return [
            'name'=>$this->name,
            'total_period_theory'=>$this->total_period_theory,
            'total_period_practice'=>$this->total_period_practice,
            'semester'=>$this->semester,
            'school_year' =>$this->school_year,
            'credit' =>$this->credit,
           
            // 'created_at' => $this?->created_at->format('d/m/Y'),
            // 'updated_at' => $this?->updated_at->format('d/m/Y'),
         ];
    }
}
