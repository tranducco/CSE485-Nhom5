<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_assignments', function (Blueprint $table) {
            $table->id();

            // Giảng viên hướng dẫn
            $table->foreignId('lecturer_id')
                  ->constrained('lecturers')
                  ->cascadeOnDelete();

            // Đề tài (bảng topics nhóm khác phụ trách)
            $table->unsignedBigInteger('topic_id');

            $table->date('assigned_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_assignments');
    }
};