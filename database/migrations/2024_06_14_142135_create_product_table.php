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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('detail')->nullable();
            $table->text('category')->default(json_encode((object)[]));
            $table->timestamps();
        });

        Schema::create('product_price', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
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
        Schema::dropIfExists('product');
        Schema::dropIfExists('product_price');
    }
};
