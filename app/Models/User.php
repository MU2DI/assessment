<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'center_code',
        'is_admin',
        'is_school_admin',
        'is_data_entry',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Add these methods for role checking
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isSchoolAdmin()
    {
        return $this->is_school_admin && $this->center_code;
    }

    public function isDataEntry()
    {
        return $this->is_data_entry && $this->center_code;
    }
    public function school()
{
    return $this->belongsTo(School::class, 'center_code', 'center_code');
}
}
