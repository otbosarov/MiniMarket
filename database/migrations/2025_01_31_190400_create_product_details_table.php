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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id',)->constrained('products')->onDelete('RESTRICT');
            $table->foreignId('unity_id',)->constrained('unities')->onDelete('RESTRICT');
            $table->integer('raise',);
            $table->string('currency_type',);
            $table->integer('currency_rate',);
            $table->float('input_price',);
            $table->float('selling_price',);
            $table->float('residue',);
            $table->foreignId('user_id',)->constrained('users')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
