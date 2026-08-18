<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SpecializationSeeder::class,
            StudentSeeder::class,
            LecturerSeeder::class,
            TopicSeeder::class,

            // Phải chạy sau Lecturer + Topic
            TopicAssignmentSeeder::class,
            EvaluationCriteriaSeeder::class,

            // Phải chạy sau TopicAssignment
            EvaluationScoreSeeder::class,
        ]);
    }
}
