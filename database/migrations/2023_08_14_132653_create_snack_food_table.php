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
        Schema::create('snack_foods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('snack_id')->unsigned()->nullable();
            $table->bigInteger('food_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->double('calories', 20,2)->default(0);
            $table->double('protein', 20,2)->default(0);
            $table->double('crabs', 20,2)->default(0);
            $table->double('fat', 20,2)->default(0);
            $table->integer('quantity')->default(0);
            $table->string('serving_size')->nullable();
            $table->string('image', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snack_foods');
    }
};
