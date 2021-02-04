<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';

    protected $fillable = [
        'nip', // primary

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

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
