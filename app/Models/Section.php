<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = ['course_id', 'section_code', 'schedule', 'start_time', 'end_time', 'days', 'available_seats', 'total_seats'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    // Check if section has available seats
    public function hasAvailableSeats()
    {
        return $this->available_seats > 0;
    }
}