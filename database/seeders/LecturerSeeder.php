<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use App\Models\User; // Nhớ import User
use Illuminate\Support\Facades\Hash; // Import Hash để băm mật khẩu

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        // Gộp dữ liệu vào một mảng để code gọn gàng và dễ lặp
        $lecturersData = [
            [
                'code' => 'GV001',
                'name' => 'Nguyen Van An',
                'email' => 'an@tlu.edu.vn',
                'phone' => '0901234567',
                'specialization_id' => 1
            ],
            [
                'code' => 'GV002',
                'name' => 'Tran Thi Binh',
                'email' => 'binh@tlu.edu.vn',
                'phone' => '0912345678',
                'specialization_id' => 2
            ]
        ];

        foreach ($lecturersData as $lec) {
            // 1. Tạo tài khoản User cho giảng viên trước (Mật khẩu: 123456, Role: lecturer)
            $user = User::firstOrCreate(
                ['email' => $lec['email']],
                [
                    'name' => $lec['name'],
                    'password' => Hash::make('123456'), 
                    'role' => 'lecturer',
                ]
            );

            // 2. Tạo hồ sơ Giảng viên và liên kết với tài khoản User vừa tạo qua user_id
            Lecturer::firstOrCreate(
                ['code' => $lec['code']],
                [
                    'user_id' => $user->id, // Gắn ID tài khoản vào
                    'name' => $lec['name'],
                    'email' => $lec['email'],
                    'phone' => $lec['phone'],
                    'specialization_id' => $lec['specialization_id']
                ]
            );
        }
    }
}