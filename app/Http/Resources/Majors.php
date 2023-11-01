<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Majors extends JsonResource
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
            'major_code'=>$this->major_code,
            // 'created_at' => $this?->created_at->format('d/m/Y'),
            // 'updated_at' => $this?->updated_at->format('d/m/Y'),
         ];
    }
}
