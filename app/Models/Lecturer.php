<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'specialization_id'
    ];

    // Một giảng viên thuộc một chuyên ngành
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    // Một giảng viên có nhiều phân công đề tài
    public function topicAssignments()
    {
        return $this->hasMany(TopicAssignment::class);
    }
}