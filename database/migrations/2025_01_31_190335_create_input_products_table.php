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
        Schema::create('input_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('RESTRICT');
            $table->foreignId('unity_id')->constrained('unities')->onDelete('RESTRICT');
            $table->integer('amount');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('RESTRICT');
            $table->enum('currency_type',['UZS','USD']);
            $table->integer('currency_rate');
            $table->float('input_price');
            $table->float('selling_price');
            $table->foreignId('user_id')->constrained('users')->onDelete('RESTRICT');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_products');
    }
};
