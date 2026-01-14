<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'course_code',
        'current_credit_hours',
        'completed_credit_hours',
        'cgpa',
        'requested_section',
        'semester',
        'reason',
        'status',
        'approved_by',
        'processed_to_registration_id',
        'admin_notes',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'current_credit_hours' => 'decimal:2',
        'completed_credit_hours' => 'decimal:2',
        'cgpa' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Get the user that made the manual registration request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved/rejected the request
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the final registration if this was processed
     */
    public function processedRegistration()
    {
        return $this->belongsTo(Registration::class, 'processed_to_registration_id');
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope for approved requests
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'APPROVED');
    }

    /**
     * Scope for rejected requests
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'REJECTED');
    }

    /**
     * Check if request is pending
     */
    public function isPending()
    {
        return $this->status === 'PENDING';
    }

    /**
     * Check if request is approved
     */
    public function isApproved()
    {
        return $this->status === 'APPROVED';
    }

    /**
     * Check if request is rejected
     */
    public function isRejected()
    {
        return $this->status === 'REJECTED';
    }

    /**
     * Check if request has been processed to a regular registration
     */
    public function isProcessed()
    {
        return $this->status === 'PROCESSED' && !is_null($this->processed_to_registration_id);
    }
}
