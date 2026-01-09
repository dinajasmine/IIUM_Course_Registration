<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric_no',
        'name',
        'email',
        'password',
        'phone',
        'program',
        'semester',
        'year',
        'faculty',
        'kulliyyah',
        'current_credit',
        'max_credit',
        'is_active'
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}