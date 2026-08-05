<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicAssignment;

class TopicAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        TopicAssignment::create([
            'lecturer_id' => 1,
            'topic_id' => 1,
            'assigned_date' => '2026-08-05'
        ]);
    }
}