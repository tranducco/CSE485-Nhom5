<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại nối sang users
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Khóa ngoại nối sang specializations
            $table->foreignId('specialization_id')->constrained('specializations');
            $table->string('student_code', 20)->unique();
            $table->string('class_name', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
