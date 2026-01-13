<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Registration extends Model
{
    use HasFactory;

    protected $table ='registrations';

<<<<<<< HEAD
    public function student(){
        return $this->belongsTo(Student::class, 'matric_no', 'matric_no');
    }

    protected $fillable = [
        'matric_no',
        'subject_id',
        'status'
    ];
    
=======
    protected $fillable = [
        'student_id',
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

>>>>>>> c9645901661f3d85a12d062af6d215c4533d03c4

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

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    
    // Add other methods you need
    public function isRegistered(): bool
    {
        return $this->status === 'registered';
    }
}