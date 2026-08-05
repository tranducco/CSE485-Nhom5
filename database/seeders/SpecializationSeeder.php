<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        Specialization::create([
            'name' => 'Cong nghe Web',
            'description' => 'Lap trinh web Laravel, PHP'
        ]);

        Specialization::create([
            'name' => 'Co so du lieu',
            'description' => 'Thiet ke va quan ly database'
        ]);
    }
}