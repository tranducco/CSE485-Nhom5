<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('specializations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $majors = [
            [
                'code' => 'HTTT',
                'name' => 'Hệ thống thông tin',
            ],
            [
                'code' => 'KTPM',
                'name' => 'Kỹ thuật phần mềm',
            ],
            [
                'code' => 'KHMT',
                'name' => 'Khoa học máy tính',
            ],
            [
                'code' => 'ANM',
                'name' => 'An ninh mạng',
            ],
            [
                'code' => 'AI',
                'name' => 'Trí tuệ nhân tạo',
            ],
            [
                'code' => 'IOT',
                'name' => 'Internet vạn vật (IoT)',
            ],
        ];

        Specialization::insert($majors);
    }
}
