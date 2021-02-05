<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassesStudent extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'student_nis',
    ];
}
