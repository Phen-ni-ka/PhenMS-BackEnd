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
        Schema::create('update_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('fullname')->nullable();
            $table->string('refresh_token');
            $table->timestamp('token_expired_at');
            $table->softdeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_users');
    }
};
