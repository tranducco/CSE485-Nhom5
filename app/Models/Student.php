<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Chống Mass Assignment
    protected $fillable = ['user_id', 'specialization_id', 'student_code', 'class_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function topicRegistrations()
    {
        return $this->hasMany(TopicRegistration::class);
    }/**
 * Một sinh viên có nhiều bài nộp mốc thực hiện.
 */
    public function milestoneSubmissions()
    {
        return $this->hasMany(MilestoneSubmission::class);
    }
}