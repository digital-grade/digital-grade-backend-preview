<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class ListStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'nis' => $this->nis,
            'nisn' => $this->nisn,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'blood_type' => $this->blood_type,
            'region' => $this->region,
        ];
    }
}
