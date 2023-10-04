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
            $table->string('email') ->nullable();
            $table->string('fullname')->nullable();
            $table->string('refresh_token');
            $table->string('password');
            $table->integer('teacher_code');
            $table->string('academic_level');
            $table->string('position');
            $table->string('department');
            $table->float('total_rate');
            $table->integer('status_id');
            $table->string('resume');
            $table->timestamps();
            $table->softdeletes();
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
