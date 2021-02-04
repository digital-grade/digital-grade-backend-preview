<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis';

    protected $fillable = [
        'nis', // primary

        'classes_id',

        'nisn',
        'name',
        'email',
        'phone_number',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'address',
        'blood_type',
        'profile_picture_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date_of_birth' => 'datetime',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function courseTeacher()
    {
        return $this->belongsToMany(CourseTeacher::class);
    }
}
