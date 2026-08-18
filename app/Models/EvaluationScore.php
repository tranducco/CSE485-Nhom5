<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationScore extends Model
{
    protected $fillable = [
        'topic_assignment_id',
        'evaluation_criteria_id',
        'score',
        'comment',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    /**
     * Điểm đánh giá thuộc về một phân công đề tài.
     */
    public function topicAssignment(): BelongsTo
    {
        return $this->belongsTo(TopicAssignment::class);
    }

    /**
     * Điểm đánh giá thuộc về một tiêu chí đánh giá.
     */
    public function evaluationCriteria(): BelongsTo
    {
        return $this->belongsTo(
            EvaluationCriteria::class,
            'evaluation_criteria_id'
        );
    }
}