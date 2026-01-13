<?php

namespace App\Models;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $fillable = [
        'code',
        'name',
        'credit',
        'faculty',
        'kulliyyah',
        'description',
        'prerequisites',
        'is_active'
    ];

     public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function registrations(){
        return $this->hasMany(Registration::class);
    }
}
