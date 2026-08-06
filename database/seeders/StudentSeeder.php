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

        // 2. Tạo User 1 (Admin) - Dùng firstOrCreate để chạy nhiều lần không bị lỗi trùng lặp
        User::firstOrCreate(
            ['email' => 'admin@tlu.edu.vn'], // Kiểm tra xem email này có chưa
            [
                'name' => 'Trần Đức Cơ (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 3. Chuẩn bị mảng 3 sinh viên demo
        $studentsData = [
            [
                'name' => 'Trần Đức Cơ',
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

        // 4. Vòng lặp tự động tạo User và Student
        foreach ($studentsData as $data) {
            // Tạo tài khoản User cho sinh viên
            $userStudent = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]
            );

            // Tạo hồ sơ Student tương ứng nối với User và Chuyên ngành
            Student::firstOrCreate(
                ['student_code' => $data['student_code']],
                [
                    'user_id' => $userStudent->id,
                    'specialization_id' => $spec->id,
                    'class_name' => $data['class_name'],
                ]
            );
        }
    }
}