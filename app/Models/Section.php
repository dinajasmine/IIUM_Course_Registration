<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'section_code',
        'section_name',
        'time_slot',
        'days',
        'venue',
        'lecturer',
        'capacity',
        'registered_count',
        'is_available'
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function isFull(): bool
    {
        return $this->registered_count >= $this->capacity;
    }
}