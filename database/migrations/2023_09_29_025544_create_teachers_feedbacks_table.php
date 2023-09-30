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
        Schema::create('teachers_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('rate');
            $table->integer('course_id');
            $table->string('content');
            $table->timestamps();
            $table->softdeletes();          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_feedbacks');

    }
};
