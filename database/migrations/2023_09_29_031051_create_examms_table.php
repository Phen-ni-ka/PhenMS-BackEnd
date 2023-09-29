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
        Schema::create('examms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->date('date');
            $table->int('teacher1_id');
            $table->int('teacher2_id');
            $table->int('type');
            $table->int('exam_time');
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
            $table->timestamps('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examms');
    }
};
