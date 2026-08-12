<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationScore;
use App\Models\TopicAssignment;

class EvaluationScoreSeeder extends Seeder
{
    public function run(): void
    {
        // Tìm phân công GV001 - TP001
        $assignment = TopicAssignment::whereHas('lecturer', function ($query) {
            $query->where('code', 'GV001');
        })
        ->whereHas('topic', function ($query) {
            $query->where('code', 'TP001');
        })
        ->first();

        if (!$assignment) {
            $this->command->warn(
                'Không tìm thấy phân công GV001 - TP001.'
            );
            return;
        }

        EvaluationScore::updateOrCreate(
            [
                'topic_assignment_id' => $assignment->id,
            ],
            [
                'score' => 8.5,
                'comment' => 'Hoàn thành tốt',
            ]
        );

        $this->command->info(
            'Tạo điểm đánh giá thành công.'
        );
    }
}
