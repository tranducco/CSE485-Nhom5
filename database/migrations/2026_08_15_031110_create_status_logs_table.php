<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_registration_id')->constrained('topic_registrations')->onDelete('cascade');
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->string('note')->nullable(); // Lý do thay đổi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_logs');
    }
};
