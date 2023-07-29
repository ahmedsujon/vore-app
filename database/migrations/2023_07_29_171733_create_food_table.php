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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->enum('added_by', ['user', 'admin'])->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('serving_size')->nullable();
            $table->double('calories')->default(0)->comment('cal');
            $table->double('crabs')->default(0)->comment('g');
            $table->double('fat')->default(0)->comment('g');
            $table->double('protein')->default(0)->comment('g');
            $table->string('barcode')->nullable();
            $table->string('image', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
