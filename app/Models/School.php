<?php
// app/Models/School.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $primaryKey = 'center_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'center_code',
        'school_name',
        'address',
        'contact_phone',
        'email',
        'is_active'
    ];

    public function levels()
{
    return $this->belongsToMany(
        Level::class, 
        'school_levels', 
        'school_code', 
        'level_id', 
        'center_code', 
        'level_id'
    );
}

    public function students()
    {
        return $this->hasMany(
            Student::class, 
            'center_code', 
            'center_code');
    }
}
