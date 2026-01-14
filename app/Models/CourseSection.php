<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSection extends Model
{
    protected $fillable = [
        'course_code', 'section_code', 'instructor', 
        'available_seats', 'total_seats', 'schedule', 'room'
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'code');
    }
}