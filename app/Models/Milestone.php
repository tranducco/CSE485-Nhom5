<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Milestone extends Model
{
    protected $fillable = [
        'topic_id',
        'title',
        'description',
        'start_date',
        'due_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Một mốc thực hiện thuộc về một đề tài.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Một mốc thực hiện có nhiều bài nộp.
     *
     * Model MilestoneSubmission sẽ tạo ở bước sau.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(MilestoneSubmission::class);
    }
}