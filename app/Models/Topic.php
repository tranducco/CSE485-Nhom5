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
     * Một đề tài có nhiều lần phân công.
     */
    public function topicAssignments(): HasMany
    {
        return $this->hasMany(TopicAssignment::class);
    }
    // Bổ sung thêm quan hệ với TopicRegistration của Cơ
    public function topicRegistrations()
    {
        return $this->hasMany(TopicRegistration::class);
    }
}