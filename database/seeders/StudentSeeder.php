<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lấy 1 chuyên ngành ngẫu nhiên (do bạn Đạt đã seed)
        $spec = Specialization::first(); 
        
        if(!$spec) {
            $this->command->warn('Chưa có chuyên ngành, hãy chạy SpecializationSeeder trước!');
            return;
        }

        // 2. Tạo User 1 (Admin) - Đổi mật khẩu thành 123456
        User::firstOrCreate(
            ['email' => 'admin@tlu.edu.vn'],
            [
                'name' => 'Trần Đức Cơ (Admin)',
                'password' => Hash::make('123456'), // Đã đổi thành 123456
                'role' => 'admin',
            ]
        );
        // 3. Chuẩn bị mảng 3 sinh viên demo
        $studentsData = [
            [
                'name' => 'Trần Đức Việt',
                'email' => 'cotd@student.tlu.edu.vn',
                'student_code' => '2251160001',
                'class_name' => '62HTTT1'
            ],
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'nva@student.tlu.edu.vn',
                'student_code' => '2251160002',
                'class_name' => '62HTTT2'
            ],
            [
                'name' => 'Lê Thị Bình',
                'email' => 'ltb@student.tlu.edu.vn',
                'student_code' => '2251160003',
                'class_name' => '62HTTT3'
            ]
        ];

        // 4. Lặp mảng để tạo User và Student đồng thời
        foreach ($studentsData as $st) {
            // Bước A: Tạo tài khoản User trước với role 'student' và pass '123456'
            $user = User::firstOrCreate(
                ['email' => $st['email']],
                [
                    'name' => $st['name'],
                    'password' => Hash::make('123456'), // Mật khẩu chung 123456
                    'role' => 'student', // Set cứng role là student
                ]
            );

            // Bước B: Tạo thông tin Sinh viên gắn với User vừa tạo
            \App\Models\Student::firstOrCreate(
                ['student_code' => $st['student_code']],
                [
                    'user_id' => $user->id,
                    'class_name' => $st['class_name'],
                    'specialization_id' => $spec->id ?? 1 // Giữ nguyên logic lấy ID chuyên ngành cũ của cậu
                ]
            );
        }
    }
}