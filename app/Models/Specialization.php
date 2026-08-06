<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }
}