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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->enum('added_by', ['user', 'admin'])->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('food_unique_id', 2048)->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->double('calories')->default(0)->comment('cal');
            $table->double('crabs')->default(0)->comment('g');
            $table->double('fat')->default(0)->comment('g');
            $table->double('protein')->default(0)->comment('g');
            $table->longText('nutrations')->nullable();
            $table->string('barcode')->nullable();
            $table->longText('images')->nullable();
            $table->longText('api_image')->nullable();
            $table->tinyInteger('is_fat_secret')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
