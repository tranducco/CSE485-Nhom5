<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_registrations', function (Blueprint $table) {
            $table->id();
            // Kết nối khóa ngoại tới bảng students
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            // Kết nối khóa ngoại tới bảng topics thông qua topic_id chuẩn của nhóm
            $table->foreignId('topic_id')->constrained('topics')->onDelete('cascade');
            
            $table->string('status')->default('Chờ duyệt'); // Các trạng thái: Chờ duyệt, Đã duyệt, Từ chối
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_registrations');
    }
};