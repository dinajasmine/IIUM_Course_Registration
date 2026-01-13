<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'credit_hours'
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class);
    }

}