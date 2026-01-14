<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_code',
        'subject_name',
        'semester'
    ];

    // Define relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}