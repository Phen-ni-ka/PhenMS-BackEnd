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
            $table->string('email')->unique();
            $table->date("email_verified_at")->nullable();
            $table->string('fullname');
            $table->string('password');
            $table->string('student_code');
            $table->tinyInteger('gender');
            $table->integer('school_year');
            $table->string('avatar_url')->nullable();
            $table->string('identity_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('home_town')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status_id')->default(0);
            $table->integer('major_id');
            $table->timestamps();
            $table->softdeletes();
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
