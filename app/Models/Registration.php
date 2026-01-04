<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;


class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'status'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
