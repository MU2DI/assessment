<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $primaryKey = 'exam_id';
    protected $fillable = [
        'exam_name', 
        'academic_year', 
        'term', 
        'level_id'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class, 'exam_id');
    }
}

