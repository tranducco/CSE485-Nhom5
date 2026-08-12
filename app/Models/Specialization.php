<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
