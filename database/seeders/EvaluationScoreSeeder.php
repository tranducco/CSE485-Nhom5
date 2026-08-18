<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationScore;
use App\Models\EvaluationCriteria;
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

        // Lấy các tiêu chí của đề tài TP001
        $criteria = EvaluationCriteria::where(
            'topic_id',
            $assignment->topic_id
        )
        ->get();

        if ($criteria->isEmpty()) {
            $this->command->warn(
                'Không tìm thấy tiêu chí đánh giá cho đề tài TP001.'
            );

            return;
        }

        /*
         * Điểm mẫu cho từng tiêu chí.
         *
         * Ví dụ:
         * Correctness -> 45
         * Quality     -> 20
         * Security    -> 25
         *
         * Nếu database của bạn đang có tên tiêu chí khác,
         * Seeder sẽ tự lấy theo thứ tự của criteria.
         */

        foreach ($criteria as $index => $criterion) {
            $sampleScores = [
                45,
                20,
                25,
            ];

            $score = $sampleScores[$index] ?? 0;

            // Không cho điểm vượt quá điểm tối đa
            $score = min($score, $criterion->max_score);

            EvaluationScore::updateOrCreate(
                [
                    'topic_assignment_id' => $assignment->id,
                    'evaluation_criteria_id' => $criterion->id,
                ],
                [
                    'score' => $score,
                    'comment' => 'Hoàn thành tốt tiêu chí.',
                ]
            );
        }

        $this->command->info(
            'Tạo điểm đánh giá theo từng tiêu chí thành công.'
        );
    }
}