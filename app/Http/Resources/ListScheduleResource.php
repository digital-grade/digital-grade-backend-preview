<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListScheduleResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->teacher == null ? null : $this->teacher->name,
            'class' => $this->class == null ? null : $this->class->name,
            'course' => $this->course == null ? null : $this->course->name,
            'school_year' => $this->schoolYear == null ? null : ($this->schoolYear->start_year . "/" . $this->schoolYear->end_year . " semester " . $this->schoolYear->semester),
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
