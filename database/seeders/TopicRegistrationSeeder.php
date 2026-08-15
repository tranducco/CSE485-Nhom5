<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicRegistration;
use App\Models\Student;
use App\Models\Topic;

class TopicRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy đại 1 sinh viên và 1 đề tài đầu tiên trong DB
        $student = Student::first();
        $topic = Topic::first();

        // Tạo 1 đơn đăng ký mẫu
        if ($student && $topic) {
            TopicRegistration::create([
                'student_id' => $student->id,
                'topic_id' => $topic->id,
                'status' => 'Chờ duyệt'
            ]);
        }
    }
}