<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;


class Registration extends Model
{
    protected $table ='registrations';

    public function student(){
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
    'user_id',
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
];


    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
