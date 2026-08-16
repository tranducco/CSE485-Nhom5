<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationCriteria extends Model
{
    protected $fillable = [
        'topic_id',
        'name',
        'description',
        'max_score',
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
    ];

    /**
     * Một tiêu chí đánh giá thuộc về một đề tài.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}