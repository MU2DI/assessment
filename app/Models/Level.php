<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
   
    protected $primaryKey = 'level_id'; 
    public $incrementing = true; // Set to false if your PK is not auto-incrementing
    protected $keyType = 'int'; // Set to 'string' if your PK is a string

     protected $fillable = [
        'level_id',    
        'level_name',
        'description'
    ];
    // Add this relationship
    public function schools()
    {
        return $this->belongsToMany(
            School::class, 
            'school_levels', 
            'level_id', 
            'school_code', 
            'level_id', 
            'center_code');
    }

    // Optional: If you need the inverse relationship
     public function students()
    {
        return $this->hasMany(
            Student::class, 
            'level_id', 
            'level_id');
    }
     public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'level_subject',
            'level_id',
            'subject_id'
        )->withTimestamps();
    }
}
