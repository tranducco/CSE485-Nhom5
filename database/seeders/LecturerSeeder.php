<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lecturer;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        Lecturer::create([
            'code' => 'GV001',
            'name' => 'Nguyen Van An',
            'email' => 'an@tlu.edu.vn',
            'phone' => '0901234567',
            'specialization_id' => 1
        ]);

        Lecturer::create([
            'code' => 'GV002',
            'name' => 'Tran Thi Binh',
            'email' => 'binh@tlu.edu.vn',
            'phone' => '0912345678',
            'specialization_id' => 2
        ]);
    }
}