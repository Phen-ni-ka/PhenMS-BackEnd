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
            $table->increments('id');
            $table->int('student_code');
            $table->date('date_of_birth');
            $table->int('gender');
            $table->string('phone_number');
            $table->string('birthplace');
            $table->string('home_town');
            $table->string('nation');
            $table->string('ward');
            $table->string('district');
            $table->string('province');
            $table->string('address');
            $table->string('identity_code');
            $table->int('status_id');
            $table->int('country_code');
            $table->int('user_id');
            $table->int('major_id');        
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
