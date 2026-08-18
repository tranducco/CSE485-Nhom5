<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluation_scores', function (Blueprint $table) {
            $table->foreignId('evaluation_criteria_id')
                ->after('topic_assignment_id')
                ->constrained('evaluation_criterias')
                ->cascadeOnDelete();

            $table->unique(
                ['topic_assignment_id', 'evaluation_criteria_id'],
                'eval_scores_assignment_criteria_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('evaluation_scores', function (Blueprint $table) {
            $table->dropUnique('eval_scores_assignment_criteria_unique');

            $table->dropForeign(['evaluation_criteria_id']);

            $table->dropColumn('evaluation_criteria_id');
        });
    }
};