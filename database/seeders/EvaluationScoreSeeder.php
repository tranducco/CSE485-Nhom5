<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationScore;

class EvaluationScoreSeeder extends Seeder
{
    public function run(): void
    {
        EvaluationScore::create([
            'topic_assignment_id' => 1,
            'score' => 8.5,
            'comment' => 'Hoan thanh tot'
        ]);
    }
}