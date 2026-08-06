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

    /**
     * Quan hệ này để sẵn.
     * Khi nhóm thêm TopicRegistration thì chỉ cần tạo Model là dùng được.
     */
    public function topicRegistrations(): HasMany
    {
        return $this->hasMany(TopicRegistration::class);
    }
}