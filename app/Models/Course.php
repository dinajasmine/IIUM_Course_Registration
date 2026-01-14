<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['code', 'title', 'description', 'credits', 'is_active'];
    
    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'course_code', 'code');
    }
}