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

    public function student(){
        return $this->belongsTo(Student::class, 'matric_no', 'matric_no');
    }

    protected $fillable = [
        'matric_no',
        'subject_id',
        'status'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
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