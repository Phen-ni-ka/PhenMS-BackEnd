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
            $table->id();            
            $table->string('subject');
            $table->date('date');
            $table->integer('teacher1_id');
            $table->integer('teacher2_id');
            $table->tinyInteger('type');
            $table->integer('exam_time');
            $table->timestamps();
            $table->softdeletes();        
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
