<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone'
    ];

    public function topicAssignments()
    {
        return $this->hasMany(TopicAssignment::class);
    }
}