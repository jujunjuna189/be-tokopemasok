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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('delivery')->nullable();
            $table->text('address')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('cart_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_price_id');
            $table->double('qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('cart_product');
    }
};
