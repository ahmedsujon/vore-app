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
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token', 2048)->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('avatar', 2000)->nullable();
            $table->string('goal', 2000)->nullable();
            $table->string('daily_activity_level', 2000)->nullable();
            $table->double('starting_weight', 20,2)->default(0);
            $table->enum('starting_weight_unit', ['lbs','kg'])->default('kg');
            $table->double('current_weight', 20,2)->default(0);
            $table->enum('current_weight_unit', ['lbs','kg'])->default('kg');
            $table->double('target_weight', 20,2)->default(0);
            $table->enum('target_weight_unit', ['lbs','kg'])->default('kg');
            $table->string('height')->default(0);
            $table->enum('height_unit', ['cm', 'ft'])->default('ft');
            $table->integer('weekly_goal')->nullable();
            $table->string('birth_date')->nullable();
            $table->longText('measurements')->nullable();
            $table->enum('measurements_unit', ['in','cm'])->default('in');
            $table->double('calories', 20,2)->default(0);
            $table->double('crabs', 20,2)->default(0);
            $table->double('protein', 20,2)->default(0);
            $table->double('fat', 20,2)->default(0);
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
