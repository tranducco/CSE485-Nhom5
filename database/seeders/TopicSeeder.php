<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::insert([
            [
                'code' => 'TP001',
                'title' => 'Hệ thống quản lý thư viện',
                'description' => 'Xây dựng website quản lý thư viện',
                'max_students' => 2,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TP002',
                'title' => 'Website bán hàng',
                'description' => 'Laravel + MySQL',
                'max_students' => 3,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TP003',
                'title' => 'Quản lý đồ án tốt nghiệp',
                'description' => 'Hệ thống đăng ký đề tài',
                'max_students' => 2,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TP004',
                'title' => 'Website học trực tuyến',
                'description' => 'E-learning System',
                'max_students' => 3,
                'status' => 'Closed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TP005',
                'title' => 'Quản lý bệnh viện',
                'description' => 'Hospital Management',
                'max_students' => 2,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}