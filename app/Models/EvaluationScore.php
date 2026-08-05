<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    protected $fillable = [
        'topic_assignment_id',
        'score',
        'comment'
    ];

    public function topicAssignment()
    {
        return $this->belongsTo(TopicAssignment::class);
    }
}