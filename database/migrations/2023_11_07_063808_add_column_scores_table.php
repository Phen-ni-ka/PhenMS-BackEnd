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
        Schema::table("scores", function (Blueprint $table) {
            $table->dropColumn("mark");
            $table->dropColumn("type");
            $table->double("theoretical_score")->after("id")->nullable();
            $table->double("midterm_score")->after("theoretical_score")->nullable();
            $table->double("final_score")->after("midterm_score")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("scores", function (Blueprint $table) {
        });
    }
};
