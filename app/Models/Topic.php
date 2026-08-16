<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'max_students',
        'status',
    ];

    /**
     * Một đề tài có nhiều đăng ký.
     */
    public function topicRegistrations(): HasMany
    {
        return $this->hasMany(TopicRegistration::class);
    }

    /**
     * Một đề tài có nhiều lần phân công giảng viên.
     */
    public function topicAssignments(): HasMany
    {
        return $this->hasMany(TopicAssignment::class);
    }

    /**
     * Một đề tài có nhiều mốc thực hiện.
     */
    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    /**
     * Một đề tài có nhiều tiêu chí đánh giá.
     */
    public function evaluationCriteria(): HasMany
    {
        return $this->hasMany(EvaluationCriteria::class);
    }
}