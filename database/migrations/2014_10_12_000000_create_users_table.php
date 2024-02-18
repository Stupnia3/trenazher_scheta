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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('parent_name')->nullable();
            $table->string('parent_surname')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('date_birth')->nullable();
            $table->string('password');
            $table->enum('role', ['student', 'teacher', 'admin']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};