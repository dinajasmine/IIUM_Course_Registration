<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSection extends Model
{
    protected $fillable = [
        'course_id',
        'section_number',
        'start_time',
        'end_time',
        'capacity',
        'enrolled'
    ];


    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function course (): BelongsTo
    {
        return $this->belongsTo (Course::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(StudentRegistration::class);
    }

    public function isFUll(): bool
    {
        return $this->enrolled >= $this->capacity;
    }

    public function availableSeats(): int
    {
        return max(0, $this->capacity - $this->enrolled);
    }
}
