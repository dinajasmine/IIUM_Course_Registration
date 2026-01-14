<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'matric_no',
        'course_name',
        'course_code',
        'current_credit_hours',
        'completed_credit_hours',
        'cgpa',
        'requested_section',
        'semester',
        'reason',
        'registration_type',
        'status',
    ];

    protected $casts = [
        'current_credit_hours' => 'decimal:2',
        'completed_credit_hours' => 'decimal:2',
        'cgpa' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // or whatever column name
    }
}