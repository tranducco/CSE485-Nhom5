<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationCriteria;
use App\Models\Topic;

class EvaluationCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $topic = Topic::where('code', 'TP001')->first();

        if (!$topic) {
            $this->command->warn(
                'Không tìm thấy đề tài TP001.'
            );

            return;
        }

        $criteria = [
            [
                'name' => 'Correctness',
                'description' => 'Mức độ đúng và đầy đủ của chức năng.',
                'max_score' => 50,
            ],
            [
                'name' => 'Quality',
                'description' => 'Chất lượng mã nguồn và giao diện.',
                'max_score' => 25,
            ],
            [
                'name' => 'Security',
                'description' => 'Mức độ bảo mật và an toàn của hệ thống.',
                'max_score' => 25,
            ],
        ];

        foreach ($criteria as $criterion) {
            EvaluationCriteria::updateOrCreate(
                [
                    'topic_id' => $topic->id,
                    'name' => $criterion['name'],
                ],
                [
                    'description' => $criterion['description'],
                    'max_score' => $criterion['max_score'],
                ]
            );
        }

        $this->command->info(
            'Tạo tiêu chí đánh giá TP001 thành công.'
        );
    }
}