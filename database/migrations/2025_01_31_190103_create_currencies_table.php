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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->enum('fromUSD',['USD','UZS'])->default('USD');
            $table->enum('toUZS',['USD','UZS'])->default('UZS');
            $table->integer('value')->default(1);
            $table->float('rate');
            $table->dateTime('startDate');
            $table->dateTime('endDate')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
