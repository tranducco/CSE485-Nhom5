<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {

            $table->id();

            $table->string('code',20)->unique();

            $table->string('title');

            $table->text('description')->nullable();

            $table->integer('max_students')->default(1);

            $table->enum('status',[
                'Open',
                'Closed'
            ])->default('Open');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};