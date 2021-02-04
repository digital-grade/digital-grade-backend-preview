<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nip',
        'class_id',
        'course_id',
        'school_year_id',

        'day',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'nip');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
