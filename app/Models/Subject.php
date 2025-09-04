<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'subject_id';
    protected $fillable = [
        'subject_name',
        'short_name',
        'subject_code',
        // 'level_id' is removed from here
    ];

    /**
     * The levels that belong to the subject.
     */
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(
            Level::class,
            'level_subject', // Pivot table name
            'subject_id',    // Foreign key on the pivot table for Subject
            'level_id'       // Foreign key on the pivot table for Level
        )->withTimestamps();
    }
}