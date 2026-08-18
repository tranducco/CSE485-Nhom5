<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TopicAssignment extends Model
{
    protected $fillable = [
        'lecturer_id',
        'topic_id',
        'assigned_date',
    ];

    /**
     * Phân công thuộc về một giảng viên.
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    /**
     * Phân công thuộc về một đề tài.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Một phân công có nhiều điểm đánh giá.
     *
     * Mỗi điểm tương ứng với một tiêu chí.
     */
    public function evaluationScores(): HasMany
    {
        return $this->hasMany(
            EvaluationScore::class,
            'topic_assignment_id'
        );
    }
}