<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilestoneSubmission extends Model
{
    protected $fillable = [
        'milestone_id',
        'student_id',
        'file_path',
        'comment',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Một bài nộp thuộc về một mốc thực hiện.
     */
    public function milestone(): BelongsTo
    {
       return $this->belongsTo(Milestone::class);
    }

    /**
     * Một bài nộp thuộc về một sinh viên.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}