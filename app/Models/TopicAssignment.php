<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicAssignment extends Model
{
    protected $fillable = [
        'lecturer_id',
        'topic_id',
        'assigned_date'
    ];

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function evaluationScore()
    {
        return $this->hasOne(EvaluationScore::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}