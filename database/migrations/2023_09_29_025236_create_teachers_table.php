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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_code');
            $table->string('academic_level');
            $table->string('position');
            $table->string('department');
            $table->float('total_rate');
            $table->integer('status_id');
            $table->integer('user_id');
            $table->string('resume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');

    }
};
