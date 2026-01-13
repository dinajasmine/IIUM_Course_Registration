<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;


class Registration extends Model
{
    protected $table ='registrations';

    protected $fillable = [
        'user_id',
        'subject_id',
        'subject_name',
        'course_code',
        'current_credit_hours',
        'completed_credit_hours',
        'cgpa',
        'requested_section',
        'semester',
        'reason',
        'registration_type',
        'status',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
    ];


     public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    // Relationship with subject (if you have subject_id)
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    
    // Scope for manual registrations
    public function scopeManual($query)
    {
        return $query->where('registration_type', 'MANUAL');
    }
    
    // Scope for pending registrations
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
