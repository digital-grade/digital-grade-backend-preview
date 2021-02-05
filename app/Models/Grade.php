<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Grade extends Pivot
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'classes_student_id',
        'schedule_id',

        'grade',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date_of_birth' => 'datetime',
    ];
}
