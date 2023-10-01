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
        Schema::create('province_district_wards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('division_type');
            $table->tinyInteger('type');
            $table->timestamps();
            $table->softdeletes();     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province_district_wards');
    }
};
