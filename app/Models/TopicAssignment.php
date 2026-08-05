<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicAssignment extends Model
{
    protected $fillable = [
        'lecturer_id',
        'topic_id',
        'assigned_date'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function evaluationScore()
    {
        return $this->hasOne(EvaluationScore::class);
    }
}