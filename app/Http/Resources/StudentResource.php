<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubjectResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'age' => $this->age,
            'department' => $this->department ? [

                   'id' => $this->department_id,
                   'department_name' => $this->department->department_name
            ] : null,
            'subject_name' => SubjectResource::collection($this->subject),
            
        ];
    }
}
