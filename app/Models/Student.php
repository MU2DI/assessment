<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
   
    protected $primaryKey = 'student_id'; // This is default, change if different
    public $incrementing = true; // Set to false if using UUIDs or non-incrementing IDs
    protected $keyType = 'int'; // Set to 'string' if using UUIDs
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'dob',
        'center_code',
        'level_id',
        'academic_year',
        'is_active',
    ];
     protected $casts = [
        'dob' => 'date', // This converts the string to Carbon date object
        'is_active' => 'boolean'
    ];

    public function school()
    {
        return $this->belongsTo(
            School::class,
            'center_code',
            'center_code'
        );
    }

    public function level()
    {
        return $this->belongsTo(
            Level::class,
            'level_id',
            'level_id'
        );
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'student_subjects'
        )
            ->withPivot('academic_year');
    }

    public function marks()
    {
        return $this->hasMany(ExamResult::class);
    }
}
