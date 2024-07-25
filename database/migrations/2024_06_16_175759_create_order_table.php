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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('order_number')->unique();
            $table->string('delivery');
            $table->text('address');
            $table->string('total');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('order_status', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('status');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->bigInteger('product_id')->comment('Relation for order product history or product');
            $table->bigInteger('product_price_id')->comment('Relation for order product price history or product price');
            $table->double('qty')->default(0);
            $table->timestamps();
        });

        Schema::create('order_product_history', function (Blueprint $table) {
            $table->bigInteger('order_product_id')->comment('Relation to table order product');
            $table->string('order_number');
            $table->bigInteger('id')->comment('Product id from table product');
            $table->bigInteger('store_id')->comment('Store id from table store');
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('detail')->nullable();
            $table->text('category')->default(json_encode((object)[]));
            $table->timestamps();
        });

        Schema::create('order_product_price_history', function (Blueprint $table) {
            $table->bigInteger('order_product_id')->comment('Relation to table order product');
            $table->string('order_number');
            $table->bigInteger('id')->comment('Product price id from table product price');
            $table->bigInteger('product_id')->comment('Product id from table product');
            $table->double('price');
            $table->double('qty')->default(1);
            $table->string('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_status');
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('order_product_history');
        Schema::dropIfExists('order_product_price_history');
    }
};
