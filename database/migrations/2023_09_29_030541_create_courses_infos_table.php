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
        Schema::create('courses_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->int('student_id');
            $table->int('teacher_id');
            $table->int('courses_id');
            $table->int('fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_infos');
    }
};
