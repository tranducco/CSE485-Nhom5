<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicAssignment;
use App\Models\Lecturer;
use App\Models\Topic;

class TopicAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        // Tìm giảng viên theo mã
        $lecturer = Lecturer::where('code', 'GV001')->first();

        // Tìm đề tài theo mã
        // Đây là bảng topics của bạn Việt
        $topic = Topic::where('code', 'TP001')->first();

        // Kiểm tra dữ liệu liên kết
        if (!$lecturer) {
            $this->command->warn(
                'Không tìm thấy giảng viên GV001.'
            );
            return;
        }

        if (!$topic) {
            $this->command->warn(
                'Không tìm thấy đề tài TP001.'
            );
            return;
        }

        TopicAssignment::updateOrCreate(
            [
                'lecturer_id' => $lecturer->id,
                'topic_id' => $topic->id,
            ],
            [
                'assigned_date' => '2026-08-05',
            ]
        );

        $this->command->info(
            'Tạo phân công GV001 - TP001 thành công.'
        );
    }
}
