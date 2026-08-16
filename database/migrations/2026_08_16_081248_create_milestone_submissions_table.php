<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestone_submissions', function (Blueprint $table) {
            $table->id();

            // Bài nộp thuộc về mốc thực hiện nào
            $table->foreignId('milestone_id')
                ->constrained('milestones')
                ->cascadeOnDelete();

            // Sinh viên nào nộp bài
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Tên/link file bài nộp
            $table->string('file_path')->nullable();

            // Nội dung ghi chú của sinh viên
            $table->text('comment')->nullable();

            // Thời gian nộp bài
            $table->timestamp('submitted_at')->nullable();

            // Trạng thái bài nộp
            $table->enum('status', [
                'Pending',
                'Submitted',
                'Reviewed'
            ])->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestone_submissions');
    }
};